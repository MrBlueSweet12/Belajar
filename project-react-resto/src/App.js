import React from 'react';
import './App.css';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Navbar from './components/Navbar';
import Home from './pages/Home';
import CustomersList from './pages/CustomersList';
import AddCustomer from './pages/AddCustomer';
import EditCustomer from './pages/EditCustomer';
import CustomerDetail from './pages/CustomerDetail';
import ChartPage from './pages/ChartPage';

function App() {
  return (
    <Router>
      <Navbar />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/customers" element={<CustomersList />} />
        <Route path="/customers/add" element={<AddCustomer />} />
        <Route path="/customers/edit/:id" element={<EditCustomer />} />
        <Route path="/customers/:id" element={<CustomerDetail />} />
        <Route path="/charts" element={<ChartPage />} />
      </Routes>
    </Router>
  );
}

export default App;
