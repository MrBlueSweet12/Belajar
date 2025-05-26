import React, { useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Register = ({ onLogin }) => {
    const [formData, setFormData] = useState({
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
    });
    const [errors, setErrors] = useState({});
    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors({});
        setLoading(true);

        try {
            // Get CSRF cookie first
            await axios.get('/sanctum/csrf-cookie');
            
            // Send registration request
            const response = await axios.post('/api/register', formData);
            
            // Call the onLogin function with token and user data
            onLogin(response.data.access_token, response.data.user);
        } catch (error) {
            console.error('Registration error:', error);
            if (error.response?.data?.errors) {
                setErrors(error.response.data.errors);
            } else {
                setErrors({
                    general: error.response?.data?.message || 
                        'An error occurred during registration. Please try again.'
                });
            }
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="row justify-content-center">
            <div className="col-md-6">
                <div className="card">
                    <div className="card-header">Register</div>
                    <div className="card-body">
                        {errors.general && (
                            <div className="alert alert-danger">{errors.general}</div>
                        )}
                        <form onSubmit={handleSubmit}>
                            <div className="mb-3">
                                <label htmlFor="name" className="form-label">Name</label>
                                <input
                                    type="text"
                                    className={`form-control ${errors.name ? 'is-invalid' : ''}`}
                                    id="name"
                                    name="name"
                                    value={formData.name}
                                    onChange={handleChange}
                                    required
                                />
                                {errors.name && (
                                    <div className="invalid-feedback">{errors.name[0]}</div>
                                )}
                            </div>
                            <div className="mb-3">
                                <label htmlFor="email" className="form-label">Email Address</label>
                                <input
                                    type="email"
                                    className={`form-control ${errors.email ? 'is-invalid' : ''}`}
                                    id="email"
                                    name="email"
                                    value={formData.email}
                                    onChange={handleChange}
                                    required
                                />
                                {errors.email && (
                                    <div className="invalid-feedback">{errors.email[0]}</div>
                                )}
                            </div>
                            <div className="mb-3">
                                <label htmlFor="password" className="form-label">Password</label>
                                <input
                                    type="password"
                                    className={`form-control ${errors.password ? 'is-invalid' : ''}`}
                                    id="password"
                                    name="password"
                                    value={formData.password}
                                    onChange={handleChange}
                                    required
                                />
                                {errors.password && (
                                    <div className="invalid-feedback">{errors.password[0]}</div>
                                )}
                            </div>
                            <div className="mb-3">
                                <label htmlFor="password_confirmation" className="form-label">Confirm Password</label>
                                <input
                                    type="password"
                                    className="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    value={formData.password_confirmation}
                                    onChange={handleChange}
                                    required
                                />
                            </div>
                            <button 
                                type="submit" 
                                className="btn btn-primary"
                                disabled={loading}
                            >
                                {loading ? 'Registering...' : 'Register'}
                            </button>
                        </form>
                        <div className="mt-3">
                            Already have an account? <Link to="/login">Login here</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Register;