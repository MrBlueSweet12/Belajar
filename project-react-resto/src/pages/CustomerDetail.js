import React, { useEffect, useState } from 'react';
import { fetchCustomerById } from '../api';
import { useParams } from 'react-router-dom';

function CustomerDetail() {
  const { id } = useParams();
  const [customer, setCustomer] = useState(null);
  const [token, setToken] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (!token) return;
    setLoading(true);
    setError('');
    fetchCustomerById(id, token)
      .then(res => {
        setCustomer(res.data);
        setLoading(false);
      })
      .catch(() => {
        setError('Failed to fetch customer.');
        setLoading(false);
      });
  }, [id, token]);

  return (
    <div className="container">
      <h2>Detail Pelanggan</h2>
      <div className="mb-3">
        <label htmlFor="token" className="form-label">API Token</label>
        <input
          type="text"
          className="form-control"
          id="token"
          value={token}
          onChange={e => setToken(e.target.value)}
          required
        />
      </div>
      {loading ? (
        <div>Loading...</div>
      ) : error ? (
        <div className="alert alert-danger">{error}</div>
      ) : customer ? (
        <table className="table table-bordered">
          <tbody>
            <tr><th>ID</th><td>{customer.id}</td></tr>
            <tr><th>Nama</th><td>{customer.nama}</td></tr>
            <tr><th>Alamat</th><td>{customer.alamat}</td></tr>
            <tr><th>Telepon</th><td>{customer.telepon}</td></tr>
          </tbody>
        </table>
      ) : null}
    </div>
  );
}

export default CustomerDetail;