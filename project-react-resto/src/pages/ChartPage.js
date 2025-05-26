import React, { useState, useEffect } from 'react';
import { 
  Chart as ChartJS, 
  CategoryScale, 
  LinearScale, 
  BarElement, 
  Title, 
  Tooltip, 
  Legend, 
  ArcElement 
} from 'chart.js';
import { Bar, Pie } from 'react-chartjs-2';
import { fetchCategoryChartData, fetchCustomerChartData } from '../api';

// Register ChartJS components
ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  Title,
  Tooltip,
  Legend,
  ArcElement
);

function ChartPage() {
  const [token, setToken] = useState('');
  const [customerChartData, setCustomerChartData] = useState(null);
  const [categoryChartData, setCategoryChartData] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  // Fetch category chart data (no token required)
  useEffect(() => {
    setLoading(true);
    fetchCategoryChartData()
      .then(res => {
        setCategoryChartData(res.data);
        setLoading(false);
      })
      .catch(err => {
        console.error('Error fetching category chart data:', err);
        setError('Failed to fetch category chart data');
        setLoading(false);
      });
  }, []);

  // Fetch customer chart data (requires token)
  useEffect(() => {
    if (!token) return;
    
    setLoading(true);
    fetchCustomerChartData(token)
      .then(res => {
        setCustomerChartData(res.data);
        setLoading(false);
      })
      .catch(err => {
        console.error('Error fetching customer chart data:', err);
        setError('Failed to fetch customer chart data');
        setLoading(false);
      });
  }, [token]);

  // Options for the bar chart
  const barOptions = {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Jumlah Pelanggan per Bulan',
      },
    },
  };

  // Options for the pie chart
  const pieOptions = {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Jumlah Item per Kategori',
      },
    },
  };

  return (
    <div className="container mt-4">
      <h2>Dashboard Chart</h2>
      
      {/* Token input for customer data */}
      <div className="mb-4">
        <label htmlFor="token" className="form-label">API Token (untuk data pelanggan)</label>
        <input
          type="text"
          className="form-control"
          id="token"
          placeholder="Masukkan API token untuk mengakses data pelanggan"
          value={token}
          onChange={e => setToken(e.target.value)}
        />
      </div>

      {loading && <p>Loading chart data...</p>}
      {error && <p className="text-danger">{error}</p>}

      <div className="row">
        {/* Category Chart (Pie) */}
        <div className="col-md-6 mb-4">
          <div className="card">
            <div className="card-header">Data Kategori</div>
            <div className="card-body">
              {categoryChartData ? (
                <Pie data={categoryChartData} options={pieOptions} />
              ) : (
                <p>Tidak ada data kategori tersedia</p>
              )}
            </div>
          </div>
        </div>

        {/* Customer Chart (Bar) */}
        <div className="col-md-6 mb-4">
          <div className="card">
            <div className="card-header">Data Pelanggan per Bulan</div>
            <div className="card-body">
              {customerChartData ? (
                <Bar data={customerChartData} options={barOptions} />
              ) : (
                <p>{token ? 'Memuat data...' : 'Masukkan token untuk melihat data pelanggan'}</p>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default ChartPage;