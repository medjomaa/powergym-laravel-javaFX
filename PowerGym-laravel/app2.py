from flask import Flask, jsonify, request
import pandas as pd
import plotly.express as px
import json
import plotly.utils
import mysql.connector
import plotly.graph_objects as go
import numpy as np
from datetime import datetime, timedelta
from sklearn.linear_model import LinearRegression

app = Flask(__name__)

custom_theme = {
    'template': 'plotly_white',
    'color_discrete_sequence': px.colors.qualitative.Bold,
    'layout': {
        'title_font_size': 22,
        'title_x': 0.5,
        'font': {'family': "Arial, sans-serif", 'size': 12, 'color': "black"},
        'paper_bgcolor': 'rgba(255,255,255,1)',
        'plot_bgcolor': 'rgba(255,255,255,1)',
        'xaxis': {'color': 'black'},
        'yaxis': {'color': 'black'},
    }
}

def apply_custom_theme(fig):
    fig.update_layout(
        template='plotly_white',
        title_font_size=22,
        title_x=0.5,
        legend_title_font_color="black",
        legend_title_font_size=14,
        legend_x=1,
        legend_y=1,
        font=dict(family="Arial, sans-serif", size=12, color="black"),
        paper_bgcolor='rgba(255,255,255,1)',
        plot_bgcolor='rgba(255,255,255,1)',
        xaxis={'color': 'black'},
        yaxis={'color': 'black'}
    )
    return fig

def get_db_connection():
    db_host = '127.0.0.1'
    db_user = 'root'
    db_password = ''
    db_name = 'powergym'
    try:
        db_connection = mysql.connector.connect(
            host=db_host,
            port="3307",
            user=db_user,
            password=db_password,
            database=db_name
        )
        return db_connection
    except mysql.connector.Error as err:
        print(f"Error: {err}")
        return None

@app.route('/api/visualizations', methods=['GET'])
def home():
    selected_date = request.args.get('date', type=str)

    db_connection = get_db_connection()
    if db_connection is None:
        return jsonify({"error": "Database connection failed."}), 500

    base_query = """
    SELECT f.*, u.created_at AS user_created_at, r.age, r.sex 
    FROM Feedback f
    LEFT JOIN Users u ON f.user_id = u.id 
    LEFT JOIN Recommendations r ON f.user_id = r.user_id
    """
    membership_query = "SELECT membership_type, paid FROM memberships"
    membership_df = pd.read_sql(membership_query, db_connection)
    try:
        if selected_date:
            query = base_query + " WHERE DATE(f.created_at) = %s"
            df = pd.read_sql(query, db_connection, params=[selected_date])
        else:
            df = pd.read_sql(base_query, db_connection)
    except mysql.connector.Error as err:
        db_connection.close()
        return jsonify({"error": "Failed to execute query."}), 500

    db_connection.close()

    df['created_at'] = pd.to_datetime(df['created_at'])
    df['user_created_at'] = pd.to_datetime(df['user_created_at'])
    df['age'].fillna(df['age'].mean(), inplace=True)
    df['sex'].fillna('Unknown', inplace=True)
    df['user_tenure_at_feedback'] = (df['created_at'] - df['user_created_at']).dt.days
    df['created_at'] = pd.to_datetime(df['created_at'])
    membership_type_counts = membership_df['membership_type'].value_counts()
    membership_pie_fig = px.pie(names=membership_type_counts.index, values=membership_type_counts.values,
                                title='Membership Type Distribution')

    paid_counts = membership_df['paid'].replace({1: 'Paid', 0: 'Pending'}).value_counts()

    # Create the bar chart
    paid_vs_unpaid_bar_fig = px.bar(x=paid_counts.index, y=paid_counts.values, color=paid_counts.index,
                                    title='Paid vs. Pending Memberships')

    # Update x-axis labels and hover text
    paid_vs_unpaid_bar_fig.update_traces(
        hoverinfo='text',
        hovertext=[f"Count: {count}" for count in paid_counts.values]
    )

    # Update the layout for better readability
    paid_vs_unpaid_bar_fig.update_layout(
        xaxis_title="Membership Status",  # Label for x-axis
        yaxis_title="Number of Memberships",  # Label for y-axis
        hovermode="x",
        hoverlabel=dict(
            bgcolor="white",
            font_size=16,
            font_family="Rockwell"
        )
    )

    # Show the counts on the left side of the bars
    paid_vs_unpaid_bar_fig.update_layout(
        annotations=[
            dict(
                x=pos,
                y=val,
                text=f"{val}",
                xanchor="left",
                yanchor="middle",
                showarrow=False,
                font=dict(
                    size=12,
                    color="black"
                ),
            )
            for pos, val in enumerate(paid_counts.values)
        ]
    )
    visualizations = []
    visualizations.append({"figure": apply_custom_theme(membership_pie_fig), "description": "Pie chart showing distribution of membership types."})
    visualizations.append({"figure": apply_custom_theme(paid_vs_unpaid_bar_fig), "description": "Bar chart showing paid vs. unpaid memberships."})

    if 'sentiment' in df.columns:
        sentiment_distribution_fig = px.pie(df, names='sentiment', title="Sentiment Distribution", color_discrete_sequence=px.colors.qualitative.Bold)
        visualizations.append({"figure": apply_custom_theme(sentiment_distribution_fig), "description": "Distribution of user sentiment in feedback."})

    feedback_daily = df.set_index('created_at').resample('D').size().reset_index(name='count')

    X = np.arange(len(feedback_daily)).reshape(-1, 1)
    y = feedback_daily['count'].values

    model = LinearRegression()
    model.fit(X, y)

    future_days = 365 * 5
    X_future = np.arange(len(feedback_daily), len(feedback_daily) + future_days).reshape(-1, 1)
    y_future = model.predict(X_future)

    future_dates = pd.date_range(start=feedback_daily['created_at'].max() + pd.Timedelta(days=1), periods=future_days)
    feedback_future = pd.DataFrame({'created_at': future_dates, 'count': y_future})

    feedback_combined = pd.concat([feedback_daily, feedback_future])

    feedback_over_time_fig = go.Figure()

    feedback_over_time_fig.add_trace(go.Scatter(x=feedback_daily['created_at'], y=feedback_daily['count'], mode='markers', name='Actual Feedback'))
    feedback_over_time_fig.add_trace(go.Scatter(x=feedback_future['created_at'], y=feedback_future['count'], mode='lines', name='Predicted Feedback', line=dict(dash='dash')))

    feedback_over_time_fig.update_layout(title='Feedback Over Time with Predictions',
                                         xaxis=dict(title='Date', rangeselector=dict(buttons=[
                                             dict(count=1, label="Next 4 Years", step="year", stepmode="todate"),
                                             dict(count=5, label="Next 5 Years", step="year", stepmode="todate"),
                                             dict(step="all")]), 
                                             rangeslider=dict(visible=True)),
                                         yaxis=dict(title='Feedback Count'))

    feedback_over_time_fig = apply_custom_theme(feedback_over_time_fig)
    visualizations.append({"figure": feedback_over_time_fig, "description": "Trend of feedback count over time with future predictions."})

    if 'age' in df.columns:
        age_distribution_fig = px.histogram(df, x='age', title="Age Distribution of Users", color_discrete_sequence=px.colors.qualitative.Set1)
        visualizations.append({"figure": apply_custom_theme(age_distribution_fig), "description": "Histogram showing the distribution of user ages."})

    if 'exercise_frequency' in df.columns:
        exercise_frequency_fig = px.bar(df, x='exercise_frequency', title="Exercise Frequency of Users", color_discrete_sequence=px.colors.qualitative.Pastel)
        visualizations.append({"figure": apply_custom_theme(exercise_frequency_fig), "description": "Bar chart showing the exercise frequency of users."})

    if 'fitness_goal' in df.columns:
        fitness_goals_fig = px.pie(df, names='fitness_goal', title="Fitness Goals Distribution", color_discrete_sequence=px.colors.sequential.Viridis)
        visualizations.append({"figure": apply_custom_theme(fitness_goals_fig), "description": "Distribution of fitness goals among users."})

    if 'time_availability' in df.columns:
        time_availability_fig = px.bar(df, x='time_availability', title="Time Availability of Users", color_discrete_sequence=px.colors.qualitative.Safe)
        visualizations.append({"figure": apply_custom_theme(time_availability_fig), "description": "Bar chart showing the time availability of users for exercise."})

    if 'equipment_quality' in df.columns and 'sentiment' in df.columns:
        equipment_quality_fig = px.bar(df, x='equipment_quality', color='sentiment', title="Equipment Quality Ratings by Sentiment", barmode='group')
        visualizations.append({"figure": apply_custom_theme(equipment_quality_fig), "description": "Bar chart showing the distribution of equipment quality ratings, grouped by user sentiment."})

    available_equipment = ['Treadmill', 'Dumbbell', 'Barbell']
    current_exercise_types = ['Cardio', 'Strength', 'Flexibility']

    equipment_exercise_correlation = pd.DataFrame(np.random.rand(len(available_equipment), len(current_exercise_types)),
                                                  index=available_equipment, columns=current_exercise_types)

    equipment_exercise_heatmap_fig = px.imshow(equipment_exercise_correlation,
                                               labels=dict(x="Exercise Types", y="Available Equipment", color="Correlation"),
                                               x=current_exercise_types,
                                               y=available_equipment,
                                               title="Available Equipment vs. Exercise Types")

    visualizations.append({"figure": apply_custom_theme(equipment_exercise_heatmap_fig), "description": "Heatmap showing the correlation between available equipment and preferred exercise types."})

    feedback_ratings = df.melt(value_vars=['cleanliness', 'equipment_quality', 'staff'],
                               var_name='Category', value_name='Rating')

    feedback_ratings_fig = px.bar(feedback_ratings, x='Category', y='Rating', color='Category',
                                  title="Feedback Category Ratings",
                                  labels={'Rating': 'Average Rating'})
    feedback_ratings_fig.update_layout(showlegend=False)

    annotations = []
    for i, rating in enumerate(feedback_ratings['Rating']):
        annotations.append(dict(x=feedback_ratings['Category'][i], y=rating, text=str(rating), showarrow=False))
    feedback_ratings_fig.update_layout(annotations=annotations)
    visualizations.append({"figure": apply_custom_theme(feedback_ratings_fig), "description": "Grouped bar chart visualizing average ratings for different feedback categories."})

    try:
        db_connection = get_db_connection()
        if db_connection is None:
            return jsonify({"error": "Database connection failed."}), 500

        product_df = pd.read_sql("SELECT id, name, stock, created_at, updated_at FROM products", db_connection)
        db_connection.close()

        product_df['created_at'] = pd.to_datetime(product_df['created_at'])
        product_df['updated_at'] = pd.to_datetime(product_df['updated_at'])

        product_stock_fig = px.line(product_df, x='updated_at', y='stock', color='name', title="Product Stock Variation Over Time")
        visualizations.append({"figure": apply_custom_theme(product_stock_fig), "description": "Line graph showing the stock variation of products over time."})
    except mysql.connector.Error as err:
        return jsonify({"error": "Failed to fetch product data."}), 500

    graphJSON = [
        {
            "data": json.loads(json.dumps(viz["figure"].data, cls=plotly.utils.PlotlyJSONEncoder)),
            "layout": json.loads(json.dumps(viz["figure"].layout, cls=plotly.utils.PlotlyJSONEncoder)),
            "description": viz["description"]
        } 
        for viz in visualizations
    ]

    return jsonify(graphJSON)

if __name__ == '__main__':
    app.run(debug=True, port=334, host='0.0.0.0')
