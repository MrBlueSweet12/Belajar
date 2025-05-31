import React, { useState, useEffect } from 'react';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';

const Kategori = () => {
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const fetchCategories = async () => {
    try {
      const response = await axios.get('http://localhost:8000/api/kategori');
      setCategories(response.data.data || []);
      setError(null);
    } catch (error) {
      console.error('Error details:', error);
      setError('Error fetching categories: ' + (error.response?.data?.message || error.message));
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchCategories();
  }, []);

  const handleDelete = async (id) => {
    if (window.confirm('Yakin akan menghapus data ini?')) {
      try {
        await axios.delete(`http://localhost:8000/api/kategori/${id}`);
        fetchCategories();
      } catch (error) {
        setError('Error deleting category: ' + error.message);
      }
    }
  };

  if (loading) return <div>Loading...</div>;
  if (error) return <div className="alert alert-danger">{error}</div>;

  return (
    <div className="container-fluid">
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2>Data Kategori</h2>
        <button className="btn btn-primary">
          Tambah Kategori
        </button>
      </div>

      <p>Jumlah data: {categories.length}</p>

      <table className="table">
        <thead className="table-dark">
          <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Keterangan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {categories.map((category, index) => (
            <tr key={category.id}>
              <td>{index + 1}</td>
              <td>{category.kategori}</td>
              <td>{category.keterangan}</td>
              <td>
                <button 
                  className="btn btn-warning btn-sm me-2"
                >
                  Edit
                </button>
                <button 
                  className="btn btn-danger btn-sm"
                  onClick={() => handleDelete(category.id)}
                >
                  Hapus
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Kategori;
