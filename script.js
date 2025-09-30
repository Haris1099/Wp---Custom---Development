document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('multiStepForm');
    const steps = [
        document.getElementById('step1'),
        document.getElementById('step2')
    ];
    let currentStep = 0;

    // Function to show a specific step
    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.style.display = index === stepIndex ? 'block' : 'none';
        });
        currentStep = stepIndex;
    }

    // Basic Validation for Step 1
    function validateStep1() {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        if (name === '' || email === '') {
            alert('Please fill in both Name and Email.');
            return false;
        }
        // Basic email format check
        if (!email.includes('@') || !email.includes('.')) {
            alert('Please enter a valid email address.');
            return false;
        }
        return true;
    }

    // Handle 'Next' Button
    form.querySelectorAll('.next-btn').forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep === 0 && validateStep1()) {
                showStep(currentStep + 1);
            }
        });
    });

    // Handle 'Back' Button
    form.querySelectorAll('.prev-btn').forEach(button => {
        button.addEventListener('click', () => {
            showStep(currentStep - 1);
        });
    });

    // Handle 'Submit'
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const budget = document.getElementById('budget').value.trim();
        
        if (budget === '' || parseInt(budget) <= 0) {
             alert('Please enter a valid project budget.');
             return;
        }

        // Simulate successful submission
        const statusMessage = document.getElementById('status');
        statusMessage.textContent = 'Submission successful! Thank you for your inquiry.';
        statusMessage.style.display = 'block';
        form.reset();
        showStep(0); 
    });

    // Initialize the form to show the first step
    showStep(0);
});
