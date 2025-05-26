import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Chart as ChartJS, CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend } from 'chart.js';
import { Bar } from 'react-chartjs-2';
import LoadingScreen from './LoadingScreen';

// Register Chart.js components
ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const Customers = () => {
    const [customers, setCustomers] = useState([]);
    const [chartData, setChartData] = useState(null);
    const [searchTerm, setSearchTerm] = useState('');
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        const fetchCustomers = async () => {
            try {
                // Fetch customers
                const customersResponse = await axios.get('/api/customers');
                setCustomers(customersResponse.data);
                
                // Fetch chart data
                const chartResponse = await axios.get('/api/customers/chart');
                
                // Prepare chart data
                setChartData({
                    labels: chartResponse.data.labels,
                    datasets: [
                        {
                            label: 'Customers by Month',
                            data: chartResponse.data.data,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                        },
                    ],
                });
            } catch (error) {
                console.error('Error fetching customers data:', error);
                if (error.response?.status === 401) {
                    setError('Authentication required. Please login to view customer data.');
                } else {
                    setError('Failed to load customers data. Please try again later.');
                }
            } finally {
                setLoading(false);
            }
        };

        fetchCustomers();
    }, []);

    const handleSearch = async (e) => {
        e.preventDefault();
        setLoading(true);
        
        try {
            const response = await axios.get(`/api/customers?name=${searchTerm}`);
            setCustomers(response.data);
        } catch (error) {
            console.error('Error searching customers:', error);
            setError('Failed to search customers. Please try again.');
        } finally {
            setLoading(false);
        }
    };

    const handlePrint = async () => {
        try {
            const response = await axios.get('/api/customers/print', { responseType: 'blob' });
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'customers.pdf');
            document.body.appendChild(link);
            link.click();
            link.remove();
        } catch (error) {
            console.error('Error printing customers:', error);
            alert('Failed to generate PDF. Please try again.');
        }
    };

    const handleGenerateReport = async () => {
        try {
            const response = await axios.get('/api/laporan');
            alert('Report generated successfully!');
            console.log(response.data);
        } catch (error) {
            console.error('Error generating report:', error);
            alert('Failed to generate report. Please try again.');
        }
    };

    if (loading) {
        return <LoadingScreen />;
    }

    if (error) {
        return <div className="alert alert-danger">{error}</div>;
    }

    return (
        <div>
            <h2>Customers</h2>

<div className="row mb-4">
    <div className="col-md-6">
        <CustomerForm onSuccess={customer => setCustomers([...customers, customer])} />
    </div>
</div>
            
            <div className="row mt-4 mb-4">
                <div className="col-md-6">
                    <form onSubmit={handleSearch} className="d-flex">
                        <input
                            type="text"
                            className="form-control me-2"
                            placeholder="Search by name"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                        />
                        <button type="submit" className="btn btn-primary">Search</button>
                    </form>
                </div>
                <div className="col-md-6 text-end">
                    <button onClick={handlePrint} className="btn btn-success me-2">
                        Print PDF
                    </button>
                    <button onClick={handleGenerateReport} className="btn btn-info">
                        Generate Report
                    </button>
                </div>
            </div>
            
            <div className="row">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-header">Customers List</div>
                        <div className="card-body">
                            {customers.length === 0 ? (
                                <p>No customers found.</p>
                            ) : (
                                <div className="table-responsive">
                                    <table className="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {customers.map(customer => (
                                                <tr key={customer.id}>
                                                    <td>{customer.id}</td>
                                                    <td>{customer.name}</td>
                                                    <td>{customer.address}</td>
                                                    <td>{customer.phone}</td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
                
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-header">Customers Chart</div>
                        <div className="card-body">
                            {chartData ? (
                                <div style={{ height: '300px' }}>
                                    <Bar 
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

// Form component for adding a customer
const CustomerForm = ({ onSuccess }) => {
    const [form, setForm] = useState({ name: '', address: '', phone: '', email: '' });
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
            const response = await axios.post('/api/customers', form);
            setForm({ name: '', address: '', phone: '', email: '' });
            if (onSuccess) onSuccess(response.data);
        } catch (error) {
            if (error.response && error.response.status === 422) {
                setErrors(error.response.data.errors || {});
            } else {
                alert('Failed to add customer.');
            }
        } finally {
            setSubmitting(false);
        }
    };

    return (
        <form onSubmit={handleSubmit} className="card card-body mb-3">
            <h5>Add Customer</h5>
            <div className="mb-2">
                <input type="text" name="name" className={`form-control${errors.name ? ' is-invalid' : ''}`} placeholder="Name" value={form.name} onChange={handleChange} />
                {errors.name && <div className="invalid-feedback">{errors.name[0]}</div>}
            </div>
            <div className="mb-2">
                <input type="text" name="address" className={`form-control${errors.address ? ' is-invalid' : ''}`} placeholder="Address" value={form.address} onChange={handleChange} />
                {errors.address && <div className="invalid-feedback">{errors.address[0]}</div>}
            </div>
            <div className="mb-2">
                <input type="text" name="phone" className={`form-control${errors.phone ? ' is-invalid' : ''}`} placeholder="Phone" value={form.phone} onChange={handleChange} />
                {errors.phone && <div className="invalid-feedback">{errors.phone[0]}</div>}
            </div>
            <div className="mb-2">
                <input type="email" name="email" className={`form-control${errors.email ? ' is-invalid' : ''}`} placeholder="Email (optional)" value={form.email} onChange={handleChange} />
                {errors.email && <div className="invalid-feedback">{errors.email[0]}</div>}
            </div>
            <button type="submit" className="btn btn-primary" disabled={submitting}>Add</button>
        </form>
    );
};

export default Customers;