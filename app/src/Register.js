import React, { useState } from 'react';
import axios from 'axios';
import { Link, useNavigate } from 'react-router-dom';

const existingUsernames = ['user1', 'user2', 'admin']; // Simulating existing usernames

const Register = () => {
  const [email, setEmail] = useState('');
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [message, setMessage] = useState('');
  const [errors, setErrors] = useState({ email: '', username: '', password: '', confirmPassword: '' });
  const navigate = useNavigate();

  const validateEmail = (email) => {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  };

  const validateUsername = (username) => {
    return existingUsernames.includes(username) ? 'Username is already taken.' : '';
  };

  const validatePassword = (password) => {
    return password.length >= 8 ? '' : 'Password must be at least 8 characters long.';
  };

  const validateConfirmPassword = (password, confirmPassword) => {
    return password !== confirmPassword ? 'Passwords do not match.' : '';
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    // Reset errors before validation
    setErrors({ email: '', username: '', password: '', confirmPassword: '' });

    // Perform validation
    const emailError = validateEmail(email) ? '' : 'Please enter a valid email.';
    const usernameError = validateUsername(username);
    const passwordError = validatePassword(password);
    const confirmPasswordError = validateConfirmPassword(password, confirmPassword);

    setErrors({ email: emailError, username: usernameError, password: passwordError, confirmPassword: confirmPasswordError });

    // If there are validation errors, don't proceed with the API call
    if (emailError || usernameError || passwordError || confirmPasswordError) {
      setMessage('Please fix the validation errors.');
      return;
    }

    try {
      const response = await axios.post('/api/register', { email, username, password });
      setMessage(response.data.message);
      navigate('/login'); // Navigate to login after successful registration
    } catch (error) {
      setMessage('Error: ' + (error.response?.data.detail || 'An error occurred'));
    }
  };

  return (
    <div style={{
      backgroundImage: "url('/street-car.jpg')",
      height: "100vh",
      display: "flex",
      justifyContent: "center",
      alignItems: "center"
    }}>
      <div style={{
        backgroundColor: "white",
        borderRadius: "8px",
        padding: "2rem",
        boxShadow: "0 4px 20px rgba(0, 0, 0, 0.1)",
      
        width: "400px",
        maxWidth: "90%",
        display: "flex",
        flexDirection: "column",
        alignItems: "center"
      }}>
        <h2 style={{ fontSize: '24px', fontWeight: 'bold', marginBottom: '1rem' }}>Create an Account</h2>
        <form onSubmit={handleSubmit} style={{ width: "100%" }}>
          {/* Username Input */}
          <div className="mb-4">
            <label className="block text-sm font-semibold mb-1">Username</label>
            <input
              type="text"
              className="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              required
              style={{ borderColor: errors.username ? 'red' : '#ccc' }} // Red border on error
            />
            {errors.username && <p className="text-red-500 text-sm mt-1">{errors.username}</p>}
          </div>

          {/* Email Input */}
          <div className="mb-4">
            <label className="block text-sm font-semibold mb-1">Email</label>
            <input
              type="email"
              className="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
              style={{ borderColor: errors.email ? 'red' : '#ccc' }} // Red border on error
            />
            {errors.email && <p className="text-red-500 text-sm mt-1">{errors.email}</p>}
          </div>

          {/* Password Input */}
          <div className="mb-4">
            <label className="block text-sm font-semibold mb-1">Password</label>
            <input
              type="password"
              className="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              required
              style={{ borderColor: errors.password ? 'red' : '#ccc' }} // Red border on error
            />
            {errors.password && <p className="text-red-500 text-sm mt-1">{errors.password}</p>}
          </div>

          {/* Confirm Password Input */}
          <div className="mb-4">
            <label className="block text-sm font-semibold mb-1">Confirm Password</label>
            <input
              type="password"
              className="w-full p-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
              value={confirmPassword}
              onChange={(e) => setConfirmPassword(e.target.value)}
              required
              style={{ borderColor: errors.confirmPassword ? 'red' : '#ccc' }} // Red border on error
            />
            {errors.confirmPassword && <p className="text-red-500 text-sm mt-1">{errors.confirmPassword}</p>}
          </div>

          {/* Submit Button */}
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
