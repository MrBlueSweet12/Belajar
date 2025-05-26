// data.js
// Helper functions for rendering and formatting data

// Render category table rows
export function renderCategoryRows(categories) {
  return categories.map((item) => (
    <tr key={item.id}>
      <td>{item.id}</td>
      <td>{item.kategori}</td>
    </tr>
  ));
}

// Render customer table rows (actions must be passed as props)
export function renderCustomerRows(customers, showCustomer, openEditForm, deleteCustomer) {
  return customers.map((item) => (
    <tr key={item.id}>
      <td>{item.id}</td>
      <td>{item.nama}</td>
      <td>{item.alamat}</td>
      <td>{item.telepon}</td>
      <td>
        <button className="btn btn-info btn-sm" onClick={() => showCustomer(item.id)}>
          Show
        </button>
        {' '}
        <button className="btn btn-warning btn-sm" onClick={() => openEditForm(item)}>
          Edit
        </button>
        {' '}
        <button className="btn btn-danger btn-sm" onClick={() => deleteCustomer(item.id)}>
          Hapus
        </button>
      </td>
    </tr>
  ));
}