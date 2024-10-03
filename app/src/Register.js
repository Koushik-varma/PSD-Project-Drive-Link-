// src/components/Register.js
import React, { useState } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

const Register = () => {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post('/api/register', { email, password });
      setMessage(response.data.message);
    } catch (error) {
      setMessage('Error: ' + error.response?.data.detail || 'An error occurred');
    }
  };

  return (
    <div style={{
      backgroundImage: "url('/street-car.jpg')",
      backgroundSize: "cover",
      backgroundPosition: "center",
      height: "100vh",
      display: "flex",
      justifyContent: "center",
      alignItems: "center"
    }}>
      <div style={{
        backgroundColor: "rgba(255, 255, 255, 0.85)",
        borderRadius: "8px",
        padding: "2rem",
        boxShadow: "0 4px 20px rgba(0, 0, 0, 0.2)",
        width: "400px",
        maxWidth: "90%",
        display: "flex",
        flexDirection: "column",
        alignItems: "center"
      }}>
        <h2 className="text-2xl font-bold text-center mb-6">Create an Account</h2>
        <form onSubmit={handleSubmit} style={{ width: "100%", display: "flex", flexDirection: "column", alignItems: "center" }}> {/* Center the form items */}
          <div className="mb-4 w-full">
            <label className="block text-sm font-semibold">Email</label>
            <input
              type="email"
              className="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />
          </div>
          <div className="mb-4 w-full">
            <label className="block text-sm font-semibold">Password</label>
            <input
              type="password"
              className="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
            />
          </div>
          <button type="submit" className="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition">
            Register
          </button>
        </form>
        <p className="mt-4 text-red-500">{message}</p>
        <div className="mt-4 text-center">
          <p>Already have an account? <Link to="/login" className="text-blue-500 hover:underline">Login here</Link></p>
        </div>
      </div>
    </div>
  );
};

export default Register;
