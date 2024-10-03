// App.js
import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Register from './Register';
import Login from './Login';
import Profile from './Profile'; // Import the Profile component

const App = () => {
  return (
    <Router>
      <Routes>
        <Route path="/register" element={<Register />} />
        <Route path="/login" element={<Login />} />
        <Route path="/Profile" element={<Profile />} /> {/* Updated route to profile-management */}
        {/* Add more routes here if needed */}
      </Routes>
    </Router>
  );
};

export default App;
