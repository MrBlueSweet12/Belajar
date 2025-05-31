import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import MainLayout from './layouts/MainLayout';
import Menu from './pages/Menu';
import Pelanggan from './pages/Pelanggan';
import Order from './pages/Order';
import OrderDetail from './pages/OrderDetail';
import Admin from './pages/Admin';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<MainLayout />}>
          <Route path="/menu" element={<Menu />} />
          <Route path="/pelanggan" element={<Pelanggan />} />
          <Route path="/order" element={<Order />} />
          <Route path="/order-detail" element={<OrderDetail />} />
          <Route path="/admin" element={<Admin />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
