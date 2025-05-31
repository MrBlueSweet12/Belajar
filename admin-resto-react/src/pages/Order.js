import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

const OrderDetail = () => {
  return (
    <div>
      <h2 className="mb-4">Detail Penjualan</h2>
      
      <div className="row mb-4">
        <div className="col-md-3">
          <input type="date" className="form-control" placeholder="mm/dd/yyyy" />
        </div>
        <div className="col-md-3">
          <input type="date" className="form-control" placeholder="mm/dd/yyyy" />
        </div>
        <div className="col-md-2">
          <button className="btn btn-primary">Filter</button>
        </div>
      </div>

      <table className="table">
        <thead className="table-dark">
          <tr>
            <th>No</th>
            <th>Faktur</th>
            <th>Tanggal Order</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colSpan="7" className="text-center">Tidak ada data detail order</td>
          </tr>
        </tbody>
      </table>
    </div>
  );
};

export default OrderDetail;