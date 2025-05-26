import React, { useEffect, useState } from 'react';
import { fetchCustomerById, updateCustomer } from '../api';
import { useParams, useNavigate } from 'react-router-dom';
import { handleInputChange, resetForm } from '../form';

function EditCustomer() {
  const { id } = useParams();
  const [form, setForm] = useState({ nama: '', alamat: '', telepon: '' });
  const [token, setToken] = useState('');
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    if (!token) return;
    fetchCustomerById(id, token)
      .then(res => setForm({ nama: res.data.nama, alamat: res.data.alamat, telepon: res.data.telepon }))
      .catch(() => setError('Failed to fetch customer.'));
  }, [id, token]);

  const handleSubmit = (e) => {
    e.preventDefault();
    setMessage('');
    setError('');
    updateCustomer(id, form, token)
      .then(() => {
        setMessage('Pelanggan berhasil diperbarui!');
        setTimeout(() => navigate('/customers'), 1000);
      })
      .catch(err => {
        if (err.response && err.response.data && err.response.data.pesan) {
          setError(err.response.data.pesan);
        } else {
          setError('Failed to update customer.');
        }
      });
  };

  return (
    <div className="container">
      <h2>Edit Pelanggan</h2>
      <form onSubmit={handleSubmit}>
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
        <div className="mb-3">
          <label htmlFor="nama" className="form-label">Nama Pelanggan</label>
          <input
            type="text"
            className="form-control"
            id="nama"
            name="nama"
            value={form.nama}
            onChange={e => handleInputChange(e, form, setForm)}
            required
          />
        </div>
        <div className="mb-3">
          <label htmlFor="alamat" className="form-label">Alamat</label>
          <input
            type="text"
            className="form-control"
            id="alamat"
            name="alamat"
            value={form.alamat}
            onChange={e => handleInputChange(e, form, setForm)}
            required
          />
        </div>
        <div className="mb-3">
          <label htmlFor="telepon" className="form-label">Telepon</label>
          <input
            type="text"
            className="form-control"
            id="telepon"
            name="telepon"
            value={form.telepon}
            onChange={e => handleInputChange(e, form, setForm)}
            required
          />
        </div>
        <button type="submit" className="btn btn-primary">Update</button>
      </form>
      {message && <div className="alert alert-success mt-3">{message}</div>}
      {error && <div className="alert alert-danger mt-3">{error}</div>}
    </div>
  );
}

export default EditCustomer;