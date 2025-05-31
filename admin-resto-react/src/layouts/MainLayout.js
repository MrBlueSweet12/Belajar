import React from 'react';
import { Link, Outlet } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';

const MainLayout = () => {
  return (
    <div className="d-flex">
      {/* Sidebar */}
      <div className="bg-light" style={{ width: '250px', minHeight: '100vh' }}>
        <div className="p-3">
          <h3>Admin Panel Resto</h3>
          <hr />
          <h5>Menu Aplikasi</h5>
          <nav className="nav flex-column">
            <Link to="/kategori" className="nav-link">Kategori</Link>
            <Link to="/menu" className="nav-link">Menu</Link>
            <Link to="/pelanggan" className="nav-link">Pelanggan</Link>
            <Link to="/order" className="nav-link">Order</Link>
            <Link to="/order-detail" className="nav-link">OrderDetail</Link>
            <Link to="/admin" className="nav-link">Admin</Link>
          </nav>
        </div>
      </div>

      {/* Main Content */}
      <div className="flex-grow-1 p-4">
        <Outlet />
      </div>
    </div>
  );
};

export default MainLayout;
