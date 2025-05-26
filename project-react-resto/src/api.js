// api.js
// All API-related functions and constants for the restaurant app
import axios from "axios";

export const API_BASE_URL = "http://localhost:8000/api";

// Fetch categories
export function fetchCategories() {
  return axios.get(`${API_BASE_URL}/categories`);
}

// Fetch category chart data
export function fetchCategoryChartData() {
  return axios.get(`${API_BASE_URL}/categories/chart`);
}

// Fetch customers (with token)
export function fetchCustomers(token) {
  return axios.get(`${API_BASE_URL}/customers`, {
    headers: { Authorization: `Bearer ${token}` },
  });
}

// Fetch customer chart data (with token)
export function fetchCustomerChartData(token) {
  return axios.get(`${API_BASE_URL}/customers/chart`, {
    headers: { Authorization: `Bearer ${token}` },
  });
}

// Fetch single customer by ID (with token)
export function fetchCustomerById(id, token) {
  return axios.get(`${API_BASE_URL}/customers/${id}`, {
    headers: { Authorization: `Bearer ${token}` }
  });
}

// Add new customer (with token)
export function addCustomer(data, token) {
  return axios.post(`${API_BASE_URL}/customers`, data, {
    headers: {
      Authorization: `Bearer ${token}`,
      "Content-Type": "application/json",
    },
  });
}

// Update customer (with token)
export function updateCustomer(id, data, token) {
  return axios.put(`${API_BASE_URL}/customers/${id}`, data, {
    headers: {
      Authorization: `Bearer ${token}`,
      'Content-Type': 'application/json'
    }
  });
}

// Delete customer (with token)
export function deleteCustomer(id, token) {
  return axios.delete(`${API_BASE_URL}/customers/${id}`, {
    headers: { Authorization: `Bearer ${token}` }
  });
}

// Print customer data (with token)
export function printCustomerData(token) {
  return axios.get(`${API_BASE_URL}/customers/print`, {
    headers: { Authorization: `Bearer ${token}` }
  });
}