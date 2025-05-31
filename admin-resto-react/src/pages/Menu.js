import React, { useState } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

const Menu = () => {
  const [menus] = useState([

  ]);

  return (
    <div>
      <div className="d-flex justify-content-between align-items-center mb-4">
        <h2>Data Menu</h2>
        <button className="btn btn-primary">Tambah Menu</button>
      </div>

      <table className="table">
        <thead className="table-dark">
          <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Menu</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          {menus.map((menu, index) => (
            <tr key={menu.id}>
              <td>{index + 1}</td>
              <td><img src={menu.gambar} alt={menu.menu} style={{width: '100px'}} /></td>
              <td>{menu.menu}</td>
              <td>{menu.kategori}</td>
              <td>{menu.deskripsi}</td>
              <td>{menu.harga}</td>
              <td>
                <button className="btn btn-warning btn-sm me-2">Edit</button>
                <button className="btn btn-danger btn-sm">Hapus</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default Menu;