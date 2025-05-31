import React from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';

const Admin = () => {
  return (
    <div>
      <h2 className="mb-4">Data User</h2>
      
      <div className="card" style={{maxWidth: '500px'}}>
        <div className="card-body">
          <form>
            <div className="mb-3">
              <label className="form-label">Email</label>
              <input 
                type="email" 
                className="form-control"
                defaultValue="aldo@gmail.com"
              />
            </div>
            
            <div className="mb-3">
              <label className="form-label">Password</label>
              <input 
                type="password" 
                className="form-control"
                defaultValue="*****"
              />
            </div>
            
            <div className="mb-3">
              <label className="form-label">Level</label>
              <select className="form-select">
                <option value="admin">Admin</option>
                <option value="koki">Koki</option>
                <option value="kasir">Kasir</option>
              </select>
            </div>

            <button type="submit" className="btn btn-success">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Admin;