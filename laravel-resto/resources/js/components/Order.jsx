import React, { useState, useEffect } from 'react';
import axios from 'axios';
import LoadingScreen from './LoadingScreen';

const Order = () => {
    const [menus, setMenus] = useState([]);
    const [cart, setCart] = useState([]);
    const [customers, setCustomers] = useState([]);
    const [selectedCustomer, setSelectedCustomer] = useState('');
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [submittingOrder, setSubmittingOrder] = useState(false);

    useEffect(() => {
        const fetchData = async () => {
            try {
                // Fetch menus
                const menusResponse = await axios.get('/api/menu');
                setMenus(menusResponse.data);

                // Fetch customers
                const customersResponse = await axios.get('/api/customers');
                setCustomers(customersResponse.data);

            } catch (error) {
                console.error('Error fetching data:', error);
                if (error.response?.status === 401) {
                    setError('Authentication required. Please login.');
                } else {
                    setError('Failed to load data. Please try again later.');
                }
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, []);

    const addToCart = (menu) => {
        setCart(prevCart => {
            const existingItem = prevCart.find(item => item.menu.id === menu.id);
            if (existingItem) {
                return prevCart.map(item =>
                    item.menu.id === menu.id
                        ? { ...item, quantity: item.quantity + 1 }
                        : item
                );
            } else {
                return [...prevCart, { menu, quantity: 1 }];
            }
        });
    };

    const removeFromCart = (menuId) => {
        setCart(prevCart => prevCart.filter(item => item.menu.id !== menuId));
    };

    const updateQuantity = (menuId, quantity) => {
        setCart(prevCart => {
            if (quantity <= 0) {
                return prevCart.filter(item => item.menu.id !== menuId);
            }
            return prevCart.map(item =>
                item.menu.id === menuId
                    ? { ...item, quantity: quantity }
                    : item
            );
        });
    };

    const calculateTotal = () => {
        return cart.reduce((total, item) => total + item.menu.price * item.quantity, 0);
    };

    const handlePlaceOrder = async () => {
        if (!selectedCustomer) {
            alert('Please select a customer.');
            return;
        }
        if (cart.length === 0) {
            alert('Your cart is empty.');
            return;
        }

        setSubmittingOrder(true);
        setError('');

        const orderData = {
            customer_id: selectedCustomer,
            order_date: new Date().toISOString().split('T')[0], // YYYY-MM-DD format
            total_price: calculateTotal(),
            items: cart.map(item => ({
                menu_id: item.menu.id,
                quantity: item.quantity,
            })),
        };

        try {
            const response = await axios.post('/api/orders', orderData);
            alert('Order placed successfully!');
            setCart([]); // Clear cart after successful order
            setSelectedCustomer(''); // Clear selected customer
            console.log('Order Response:', response.data);
        } catch (error) {
            console.error('Error placing order:', error);
            if (error.response?.status === 422) {
                setError('Validation Error: ' + JSON.stringify(error.response.data.errors));
            } else if (error.response?.status === 401) {
                 setError('Authentication required. Please login.');
            } else {
                setError('Failed to place order. Please try again.');
            }
        } finally {
            setSubmittingOrder(false);
        }
    };

    if (loading) {
        return <LoadingScreen />;
    }

    if (error && error.includes('Authentication required')) {
         return <div className="alert alert-danger">{error}</div>;
    }

    return (
        <div className="container mt-4">
            <h2>Create New Order</h2>

            {error && <div className="alert alert-danger">{error}</div>}

            <div className="row">
                {/* Menu List */}
                <div className="col-md-8">
                    <div className="card mb-4">
                        <div className="card-header">Menu Items</div>
                        <div className="card-body">
                            <div className="row">
                                {menus.map(menu => (
                                    <div key={menu.id} className="col-md-4 mb-3">
                                        <div className="card h-100">
                                            {menu.image_url && (
                                                <img src={menu.image_url} className="card-img-top" alt={menu.name} style={{ height: '150px', objectFit: 'cover' }} />
                                            )}
                                            <div className="card-body d-flex flex-column">
                                                <h5 className="card-title">{menu.name}</h5>
                                                <p className="card-text">{menu.description}</p>
                                                <p className="card-text"><strong>Rp {parseFloat(menu.price).toLocaleString('id-ID')}</strong></p>
                                                <button
                                                    className="btn btn-primary mt-auto"
                                                    onClick={() => addToCart(menu)}
                                                >
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>

                {/* Order Summary / Cart */}
                <div className="col-md-4">
                    <div className="card">
                        <div className="card-header">Order Summary</div>
                        <div className="card-body">
                            {cart.length === 0 ? (
                                <p>Cart is empty.</p>
                            ) : (
                                <ul className="list-group list-group-flush">
                                    {cart.map(item => (
                                        <li key={item.menu.id} className="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                {item.menu.name} (Rp {parseFloat(item.menu.price).toLocaleString('id-ID')})
                                                <br />
                                                <div className="input-group input-group-sm mt-1" style={{ width: '120px' }}>
                                                    <button className="btn btn-outline-secondary" type="button" onClick={() => updateQuantity(item.menu.id, item.quantity - 1)}>-</button>
                                                    <input type="text" className="form-control text-center" value={item.quantity} onChange={(e) => updateQuantity(item.menu.id, parseInt(e.target.value) || 0)} />
                                                    <button className="btn btn-outline-secondary" type="button" onClick={() => updateQuantity(item.menu.id, item.quantity + 1)}>+</button>
                                                </div>
                                            </div>
                                            <span>Rp {parseFloat(item.menu.price * item.quantity).toLocaleString('id-ID')}</span>
                                            <button className="btn btn-danger btn-sm ms-2" onClick={() => removeFromCart(item.menu.id)}>X</button>
                                        </li>
                                    ))}
                                </ul>
                            )}

                            <h5 className="mt-3">Total: Rp {parseFloat(calculateTotal()).toLocaleString('id-ID')}</h5>

                            <div className="mb-3">
                                <label htmlFor="customerSelect" className="form-label">Select Customer:</label>
                                <select
                                    className="form-select"
                                    id="customerSelect"
                                    value={selectedCustomer}
                                    onChange={(e) => setSelectedCustomer(e.target.value)}
                                >
                                    <option value="">-- Select Customer --</option>
                                    {customers.map(customer => (
                                        <option key={customer.id} value={customer.id}>{customer.name}</option>
                                    ))}
                                </select>
                            </div>

                            <button
                                className="btn btn-success w-100"
                                onClick={handlePlaceOrder}
                                disabled={cart.length === 0 || !selectedCustomer || submittingOrder}
                            >
                                {submittingOrder ? 'Placing Order...' : 'Place Order'}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Order;