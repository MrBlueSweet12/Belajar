import React, { useEffect, useState } from 'react';
import { fetchCategories } from '../api';

function Home() {
  const [categories, setCategories] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    setLoading(true);
    setError('');
    fetchCategories()
      .then(res => {
        setCategories(res.data);
        setLoading(false);
      })
      .catch(() => {
        setError('Failed to fetch categories.');
        setLoading(false);
      });
  }, []);

  return (
    <div className="container">
      <h2>Data Kategori</h2>
      <table className="table table-bordered table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Kategori</th>
          </tr>
        </thead>
        <tbody>
          {loading ? (
            <tr><td colSpan="2">Loading...</td></tr>
          ) : error ? (
            <tr><td colSpan="2" className="text-danger">{error}</td></tr>
          ) : (
            categories.map(item => (
              <tr key={item.id}>
                <td>{item.id}</td>
                <td>{item.kategori}</td>
              </tr>
            ))
          )}
        </tbody>
      </table>
    </div>
  );
}

export default Home;