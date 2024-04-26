// MultiStepForm.jsx

import React, { useState } from 'react';
import '../../styles/app.css'; // Import CSS file for transitions

const MultiStepForm = () => {
    const [formData, setFormData] = useState({
        firstName: '',
        lastName: '',
    });

    const [currentStep, setCurrentStep] = useState(1);
    const [error, setError] = useState(null);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            // Here you can submit formData to the backend
            // Example:
            // const response = await fetch('/submit-form', {
            //   method: 'POST',
            //   body: JSON.stringify(formData),
            //   headers: {
            //     'Content-Type': 'application/json'
            //   }
            // });
            // if (!response.ok) {
            //   throw new Error('Failed to submit form');
            // }
            // Handle successful form submission
            alert('Form submitted successfully!');
            location.reload();
        } catch (error) {
            setError(error.message);
        }
    };

    const nextStep = (e) => {
        e.preventDefault();
        setCurrentStep(currentStep + 1);
    };

    const prevStep = () => {
        setCurrentStep(currentStep - 1);
    };

    return (
      <div className="form-container">
          <div className="form-wrapper">
              <div className={`form-step ${currentStep === 1 ? 'active' : ''}`}>
                  <form onSubmit={nextStep}>
                      <label>
                          First Name:
                          <input
                            type="text"
                            name="firstName"
                            value={formData.firstName}
                            onChange={handleInputChange}
                            required
                          />
                      </label>
                      <button type="submit">Next</button>
                  </form>
              </div>

              <div className={`form-step ${currentStep === 2 ? 'active' : ''}`}>
                  <form onSubmit={handleSubmit}>
                      <label>
                          Last Name:
                          <input
                            type="text"
                            name="lastName"
                            value={formData.lastName}
                            onChange={handleInputChange}
                            required
                          />
                      </label>
                      {error && <div>{error}</div>}
                      <button type="button" onClick={prevStep}>Previous</button>
                      <button type="submit">Submit</button>
                  </form>
              </div>
          </div>
      </div>
    );
};

export default MultiStepForm;
