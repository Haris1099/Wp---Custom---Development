# Wp---Custom---Development
Client Onboarding: Multi-Step Form Module
This repository contains a fully responsive, client-side interactive module built with plain HTML, CSS, and JavaScript. The goal of this module is to demonstrate fundamental front-end skills, focusing on User Experience (UX) and Client-Side Validation.

This component is ideal for embedding within a WordPress site or using as a standalone data capture tool before submission to a back-end system.

🛠️ Technology Stack
HTML5: Semantic structure.

CSS3: Styling and media queries for responsiveness.

Vanilla JavaScript (ES6+): For all interactivity, form handling, and validation logic.

✨ Key Features Demonstrated
This module showcases the following development best practices:

Multi-Step Navigation: Implements a smooth, JavaScript-driven transition between form steps, improving user retention and experience by breaking down a long process.

Client-Side Validation: Ensures required fields are completed and checks basic email format before allowing the user to proceed to the next step (Step 1).

Responsive Design: Utilizes CSS media queries to ensure the form layout is clean, usable, and accessible across various screen sizes, from mobile phones to desktop monitors.

Clean Separation of Concerns: Logic is cleanly separated: HTML for structure (index.html), CSS for presentation (style.css), and JavaScript for behavior (script.js).

🚀 How to Run and Test
Since this is a client-side module, no server or build process is required.

Clone the Repository or download the files (index.html, style.css, script.js).

Open index.html in any web browser (Chrome, Firefox, Safari, etc.).

Test Cases
To quickly evaluate functionality, please perform the following checks:

Test Case	Expected Result
Fail Step 1 Validation	Error: An alert message pops up if the Name or Email fields are empty, preventing navigation to Step 2.
Complete Step 1	The form successfully hides Step 1: Contact Details and shows Step 2: Project Scope.
Test Responsiveness	Shrink your browser window to a mobile size (or use browser dev tools). The form container should adapt cleanly and remain centered.
Successful Submission	After entering the Project Type and Budget, the Submit button resets the form and displays a green "Submission successful!" message.
