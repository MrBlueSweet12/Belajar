import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import axios from 'axios';
import LoadingScreen from './LoadingScreen';

// Components
import Navbar from './Navbar';
import Login from './auth/Login';
import Register from './auth/Register';
import Dashboard from './Dashboard';
import Categories from './Categories';
import Customers from './Customers';
import Order from './Order';
import ProtectedRoute from './ProtectedRoute';
import ManageUsers from './ManageUsers';

const App = () => {
    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Check if user is authenticated
        const checkAuth = async () => {
            try {
                // Get CSRF cookie first
                await axios.get('/sanctum/csrf-cookie');
                
                const token = localStorage.getItem('token');
                
                if (token) {
                    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                    
                    const response = await axios.get('/api/user');
                    setUser(response.data);
                    setIsAuthenticated(true);
                }
            } catch (error) {
                console.error('Authentication check failed:', error);
                localStorage.removeItem('token');
                delete axios.defaults.headers.common['Authorization'];
            } finally {
                setLoading(false);
            }
        };

        checkAuth();
    }, []);

    const login = (token, userData) => {
        localStorage.setItem('token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        setUser(userData);
        setIsAuthenticated(true);
    };

    const logout = async () => {
        try {
            await axios.post('/api/logout');
        } catch (error) {
            console.error('Logout failed:', error);
        } finally {
            localStorage.removeItem('token');
            delete axios.defaults.headers.common['Authorization'];
            setUser(null);
            setIsAuthenticated(false);
        }
    };

    if (loading) {
        return <LoadingScreen />;
    }

    return (
        <Router>
            <div className="app">
                <Navbar isAuthenticated={isAuthenticated} user={user} onLogout={logout} />
                <div className="container mt-4">
                    <Routes>
                        <Route path="/login" element={
                            isAuthenticated ? 
                            <Navigate to="/dashboard" /> : 
                            <Login onLogin={login} />
                        } />
                        <Route path="/register" element={
                            isAuthenticated ? 
                            <Navigate to="/dashboard" /> : 
                            <Register onLogin={login} />
                        } />
                        <Route path="/dashboard" element={
                            <ProtectedRoute isAuthenticated={isAuthenticated}>
                                <Dashboard user={user} />
                            </ProtectedRoute>
                        } />
                        <Route path="/categories" element={<Categories />} />
                        <Route path="/customers" element={
                            <ProtectedRoute isAuthenticated={isAuthenticated}>
                                <Customers />
                            </ProtectedRoute>
                        } />
                        <Route path="/users" element={
                            <ProtectedRoute isAuthenticated={isAuthenticated}>
                                <ManageUsers />
                            </ProtectedRoute>
                        } />
                        <Route path="/orders" element={
                            <ProtectedRoute isAuthenticated={isAuthenticated}>
                                <Order />
                            </ProtectedRoute>
                        } />
                        <Route path="/" element={<Navigate to="/dashboard" />} />
                    </Routes>
                            <ProtectedRoute isAuthenticated={isAuthenticated}>
                                <Customers />
                            </ProtectedRoute>
                        } />
                        <Route path="/" element={<Navigate to="/dashboard" />} />
                    </Routes>
                </div>
            </div>
        </Router>
    );
};

export default App;