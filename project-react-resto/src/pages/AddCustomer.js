import React, { useState } from 'react';
import { addCustomer } from '../api';
import { useNavigate } from 'react-router-dom';
import { handleInputChange, resetForm } from '../form';

function AddCustomer() {
  const [form, setForm] = useState({ nama: '', alamat: '', telepon: '' });
  const [token, setToken] = useState('');
  const [message, setMessage] = useState('');
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleSubmit = (e) => {
    e.preventDefault();
    setMessage('');
    setError('');
    addCustomer(form, token)
      .then(() => {
        setMessage('Pelanggan berhasil ditambahkan!');
        resetForm(setForm, { nama: '', alamat: '', telepon: '' });
        setTimeout(() => navigate('/customers'), 1000);
      })
      .catch(err => {
        if (err.response && err.response.data && err.response.data.message) {
          setError(err.response.data.message);
        } else {
          setError('Failed to add customer.');
        }
      });
  };

  return (
    <div className="container">
      <h2>Tambah Pelanggan Baru</h2>
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
        <button type="submit" className="btn btn-success">Tambah</button>
      </form>
      {message && <div className="alert alert-success mt-3">{message}</div>}
      {error && <div className="alert alert-danger mt-3">{error}</div>}
    </div>
  );
}

export default AddCustomer;