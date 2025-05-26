import React from 'react';

const spinnerStyle = {
  width: '4rem',
  height: '4rem',
  border: '0.5rem solid #f3f3f3',
  borderTop: '0.5rem solid #3498db',
  borderRadius: '50%',
  animation: 'spin 1s linear infinite',
  margin: '0 auto',
  display: 'block',
};

const containerStyle = {
  display: 'flex',
  flexDirection: 'column',
  alignItems: 'center',
  justifyContent: 'center',
  height: '60vh',
};

const textStyle = {
  marginTop: '1.5rem',
  fontSize: '1.5rem',
  color: '#555',
  fontWeight: 'bold',
  letterSpacing: '1px',
};

const LoadingScreen = () => (
  <div style={containerStyle}>
    <div style={spinnerStyle} className="loading-spinner" />
    <div style={textStyle}>Loading...</div>
    <style>{`
      @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
    `}</style>
  </div>
);

export default LoadingScreen;