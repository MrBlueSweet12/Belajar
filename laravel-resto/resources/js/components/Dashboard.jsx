import React, { useState, useEffect } from 'react';
import axios from 'axios';
import LoadingScreen from './LoadingScreen';

const Dashboard = ({ user }) => {
    const [stats, setStats] = useState({
        categories: 0,
        customers: 0
    });
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        const fetchStats = async () => {
            try {
                // Fetch categories count
                const categoriesResponse = await axios.get('/api/categories');
                
                // Fetch customers count if authenticated
                let customersCount = 0;
                if (user) {
                    try {
                        const customersResponse = await axios.get('/api/customers');
                        customersCount = customersResponse.data.length;
                    } catch (error) {
                        console.error('Error fetching customers:', error);
                    }
                }
                
                setStats({
                    categories: categoriesResponse.data.length,
                    customers: customersCount
                });
            } catch (error) {
                console.error('Error fetching dashboard data:', error);
                setError('Failed to load dashboard data. Please try again later.');
            } finally {
                setLoading(false);
            }
        };

        fetchStats();
    }, [user]);

    if (loading) {
        return <LoadingScreen />;
    }

    if (error) {
        return <div className="alert alert-danger">{error}</div>;
    }

    return (
        <div>
            <h2>Dashboard</h2>
            <div className="row mt-4">
                <div className="col-md-4">
                    <div className="card bg-primary text-white">
                        <div className="card-body">
                            <h5 className="card-title">Categories</h5>
                            <p className="card-text display-4">{stats.categories}</p>
                        </div>
                    </div>
                </div>
                {user && (
                    <div className="col-md-4">
                        <div className="card bg-success text-white">
                            <div className="card-body">
                                <h5 className="card-title">Customers</h5>
                                <p className="card-text display-4">{stats.customers}</p>
                            </div>
                        </div>
                    </div>
                )}
            </div>
            <div className="row mt-4">
                <div className="col-12">
                    <div className="card">
                        <div className="card-header">Welcome</div>
                        <div className="card-body">
                            <h5 className="card-title">Hello, {user ? user.name : 'Guest'}!</h5>
                            <p className="card-text">
                                Welcome to the Restaurant Management System. This dashboard provides an overview of your restaurant data.
                                {!user && (
                                    <span> Please login to access all features.</span>
                                )}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Dashboard;