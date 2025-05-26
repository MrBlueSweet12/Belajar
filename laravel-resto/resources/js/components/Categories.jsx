import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import { Pie } from 'react-chartjs-2';
import LoadingScreen from './LoadingScreen';

// Register Chart.js components
ChartJS.register(ArcElement, Tooltip, Legend);

const Categories = () => {
    const [categories, setCategories] = useState([]);
    const [chartData, setChartData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        const fetchCategories = async () => {
            try {
                // Fetch categories
                const categoriesResponse = await axios.get('/api/categories');
                setCategories(categoriesResponse.data);
                
                // Fetch chart data
                const chartResponse = await axios.get('/api/categories/chart');
                
                // Prepare chart data
                setChartData({
                    labels: chartResponse.data.labels,
                    datasets: [
                        {
                            label: 'Categories',
                            data: chartResponse.data.data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                            ],
                            borderWidth: 1,
                        },
                    ],
                });
            } catch (error) {
                console.error('Error fetching categories data:', error);
                setError('Failed to load categories data. Please try again later.');
            } finally {
                setLoading(false);
            }
        };

        fetchCategories();
    }, []);

    if (loading) {
        return <LoadingScreen />;
    }

    if (error) {
        return <div className="alert alert-danger">{error}</div>;
    }

    return (
        <div>
            <h2>Categories</h2>

<div className="row mb-4">
    <div className="col-md-6">
        <CategoryForm onSuccess={category => setCategories([...categories, category])} />
    </div>
</div>
            
            <div className="row mt-4">
                <div className="col-md-6">
                    <div className="card">
                        <div className="card-header">Categories List</div>
                        <div className="card-body">
                            {categories.length === 0 ? (
                                <p>No categories found.</p>
                            ) : (
                                <div className="table-responsive">
                                    <table className="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {categories.map(category => (
                                                <tr key={category.id}>
                                                    <td>{category.id}</td>
                                                    <td>{category.name}</td>
                                                    <td>{category.description}</td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
                
                <div className="col-md-6">
                    <div className="card">
                        <div className="card-header">Categories Chart</div>
                        <div className="card-body">
                            {chartData ? (
                                <div style={{ height: '300px' }}>
                                    <Pie 
                                        data={chartData} 
                                        options={{
                                            responsive: true,
                                            maintainAspectRatio: false,
                                        }}
                                    />
                                </div>
                            ) : (
                                <p>No chart data available.</p>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

// Form component for adding a category
const CategoryForm = ({ onSuccess }) => {
    const [form, setForm] = useState({ name: '', description: '' });
    const [errors, setErrors] = useState({});
    const [submitting, setSubmitting] = useState(false);

    const handleChange = e => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async e => {
        e.preventDefault();
        setSubmitting(true);
        setErrors({});
        try {
            const response = await axios.post('/api/categories', form);
            setForm({ name: '', description: '' });
            if (onSuccess) onSuccess(response.data);
        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors || {});
            } else {
                alert('Failed to add category.');
            }
        } finally {
            setSubmitting(false);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="card card-body mb-3">
            <h5>Add Category</h5>
            <div className="mb-2">
                <input type="text" name="name" className={`form-control${errors.name ? ' is-invalid' : ''}`} placeholder="Name" value={form.name} onChange={handleChange} />
                {errors.name && <div className="invalid-feedback">{errors.name[0]}</div>}
            </div>
            <div className="mb-2">
                <input type="text" name="description" className={`form-control${errors.description ? ' is-invalid' : ''}`} placeholder="Description (optional)" value={form.description} onChange={handleChange} />
                {errors.description && <div className="invalid-feedback">{errors.description[0]}</div>}
            </div>
            <button type="submit" className="btn btn-primary" disabled={submitting}>Add</button>
        </form>
    );
};

export default Categories;