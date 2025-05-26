import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { fetchCustomers } from '../api';

function CustomersList() {
  const [customers, setCustomers] = useState([]);
  const [token, setToken] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    if (!token) return;
    setLoading(true);
    setError('');
    fetchCustomers(token)
      .then(res => {
        setCustomers(res.data);
        setLoading(false);
      })
      .catch(() => {
        setError('Failed to fetch customers.');
        setLoading(false);
      });
  }, [token]);

  return (
    <div className="container">
      <h2>Data Pelanggan</h2>
      <div className="mb-3">
        <label htmlFor="token" className="form-label">API Token</label>
        <input
          type="text"
          className="form-control"
          id="token"
          placeholder="Enter API token for pelanggan endpoint"
          value={token}
          onChange={e => setToken(e.target.value)}
        />
      </div>
      <table className="table table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Pelanggan</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          {loading ? (
            <tr><td colSpan="5">Loading...</td></tr>
          ) : error ? (
            <tr><td colSpan="5" className="text-danger">{error}</td></tr>
          ) : (
            customers.map(item => (
              <tr key={item.id}>
                <td>{item.id}</td>
                <td>{item.nama}</td>
                <td>{item.alamat}</td>
                <td>{item.telepon}</td>
                <td>
                  <Link className="btn btn-info btn-sm me-1" to={`/customers/${item.id}`}>Show</Link>
                  <Link className="btn btn-warning btn-sm me-1" to={`/customers/edit/${item.id}`}>Edit</Link>
                </td>
              </tr>
            ))
          )}
        </tbody>
      </table>
      <Link className="btn btn-success" to="/customers/add">Tambah Pelanggan</Link>
    </div>
  );
}

export default CustomersList;