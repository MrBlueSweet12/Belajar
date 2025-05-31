import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

const Pelanggan = () => {
  const [pelanggans] = useState([
  ]);

  return (
    <div>
      <h2 className="mb-4">Data Pelanggan</h2>
      
      <table className="table">
        <thead className="table-dark">
          <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Alamat</th>
            <th>Telp</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {pelanggans.map((pelanggan, index) => (
            <tr key={pelanggan.id}>
              <td>{index + 1}</td>
              <td>{pelanggan.pelanggan}</td>
              <td>{pelanggan.alamat}</td>
              <td>{pelanggan.telp}</td>
              <td>
                <button className="btn btn-danger btn-sm">Hapus</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Pelanggan;