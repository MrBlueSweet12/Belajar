import React, { useState, useEffect } from 'react';
import axios from 'axios';

const ManageUsers = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [success, setSuccess] = useState('');
    const [deletingId, setDeletingId] = useState(null);

    useEffect(() => {
        fetchUsers();
    }, []);

    const fetchUsers = async () => {
        setLoading(true);
        setError('');
        try {
            const response = await axios.get('/api/users');
            setUsers(response.data);
        } catch (err) {
            setError('Failed to fetch users.');
        } finally {
            setLoading(false);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm('Are you sure you want to delete this user?')) return;
        setDeletingId(id);
        setError('');
        setSuccess('');
        try {
            await axios.delete(`/api/users/${id}`);
            setUsers(users.filter(user => user.id !== id));
            setSuccess('User deleted successfully.');
        } catch (err) {
            if (err.response && err.response.status === 403) {
                setError('You do not have permission to delete this user.');
            } else if (err.response && err.response.status === 404) {
                setError('User not found.');
            } else {
                setError('Failed to delete user.');
            }
        } finally {
            setDeletingId(null);
        }
    };

    if (loading) return <div>Loading users...</div>;
    return (
        <div>
            <h2>Manage Users</h2>
            {error && <div className="alert alert-danger">{error}</div>}
            {success && <div className="alert alert-success">{success}</div>}
            <div className="table-responsive">
                <table className="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {users.map(user => (
                            <tr key={user.id}>
                                <td>{user.id}</td>
                                <td>{user.name}</td>
                                <td>{user.email}</td>
                                <td>
                                    <button className="btn btn-danger btn-sm" onClick={() => handleDelete(user.id)} disabled={deletingId === user.id}>
                                        {deletingId === user.id ? 'Deleting...' : 'Delete'}
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default ManageUsers;