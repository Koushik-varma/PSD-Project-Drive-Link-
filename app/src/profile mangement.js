import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Profile = () => {
  const [user, setUser] = useState({ name: '', email: '', profilePicture: '' });
  const [message, setMessage] = useState('');

  useEffect(() => {
    axios.get('/api/profile')
      .then(response => setUser(response.data))
      .catch(error => setMessage('Error: ' + (error.response?.data.detail || 'An error occurred')));
  }, []);

  const handleSubmit = (e) => {
    e.preventDefault();
    const formData = new FormData();
    formData.append('name', user.name);
    if (user.profilePicture) {
      formData.append('profilePicture', user.profilePicture);
    }

    axios.post('/api/profile', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
    .then(response => setMessage(response.data.message))
    .catch(error => setMessage('Error: ' + (error.response?.data.detail || 'An error occurred')));
  };

  return (
    <div className="container mx-auto p-8">
      <h2 className="text-2xl mb-6">Profile Management</h2>
      <form onSubmit={handleSubmit}>
        <div className="mb-4">
          <label className="block text-sm font-bold">Name</label>
          <input
            type="text"
            className="w-full p-2 border"
            value={user.name}
            onChange={(e) => setUser({ ...user, name: e.target.value })}
            required
          />
        </div>
        <div className="mb-4">
          <label className="block text-sm font-bold">Email</label>
          <input
            type="email"
            className="w-full p-2 border"
            value={user.email}
            readOnly
          />
        </div>
        <div className="mb-4">
          <label className="block text-sm font-bold">Profile Picture</label>
          <input
            type="file"
            className="w-full p-2"
            onChange={(e) => setUser({ ...user, profilePicture: e.target.files[0] })}
          />
        </div>
        <button type="submit" className="bg-green-500 text-white p-2">Update Profile</button>
      </form>
      <p className="mt-4 text-red-500">{message}</p>
    </div>
  );
};

export default Profile;
