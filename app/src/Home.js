// src/components/Home.js
import React from 'react';
import { useNavigate } from 'react-router-dom'; // Import useNavigate for navigation

const Home = () => {
  const navigate = useNavigate(); // Get the navigate function

  return (
    <div style={styles.container}>
      <h1>Welcome to DriveLink!</h1>
      <div style={styles.buttonContainer}>
        <button style={styles.button} onClick={() => navigate('/login')}>
          Login
        </button>
        <button style={styles.button} onClick={() => navigate('/register')}>
          Sign Up
        </button>
      </div>
    </div>
  );
};

// Styles for the Home component
const styles = {
  container: {
    display: 'flex',               // Use flexbox for alignment
    flexDirection: 'column',       // Arrange items in a column
    justifyContent: 'center',      // Center vertically
    alignItems: 'center',          // Center horizontally
    height: '100vh',               // Full viewport height
    textAlign: 'center',
    margin: '0',                   // Remove default margin
  },
  buttonContainer: {
    display: 'flex',
    justifyContent: 'center',
    gap: '20px',
    marginTop: '20px',            // Space between heading and buttons
  },
  button: {
    padding: '10px 20px',
    fontSize: '16px',
    cursor: 'pointer',
    borderRadius: '5px',
    border: '1px solid #007BFF',
    backgroundColor: '#007BFF',
    color: 'white',
    transition: 'background-color 0.3s',
  },
};

export default Home;
