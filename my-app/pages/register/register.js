document.addEventListener('DOMContentLoaded', function () {
    const nextButton = document.getElementById('next-btn');
    const prevButton = document.getElementById('prev-btn');
    const steps = document.querySelectorAll('.step-content');
    let currentStep = 0;

    // Log initial state
    console.log("Initial state:", { currentStep, steps: steps.length });

    nextButton.addEventListener('click', function () {
        console.log("Next button clicked on step:", currentStep);
        if (currentStep < steps.length - 1) {
            steps[currentStep].style.display = 'none';
            currentStep++;
            steps[currentStep].style.display = 'block';
            console.log("Current step updated to:", currentStep);
        }
        updateButtons();
    });

    prevButton.addEventListener('click', function () {
        console.log("Previous button clicked on step:", currentStep);
        if (currentStep > 0) {
            steps[currentStep].style.display = 'none';
            currentStep--;
            steps[currentStep].style.display = 'block';
            console.log("Current step updated to:", currentStep);
        }
        updateButtons();
    });

    function updateButtons() {
        prevButton.style.display = currentStep === 0 ? 'none' : 'block';
        nextButton.style.display = currentStep === steps.length - 1 ? 'none' : 'block';
        document.getElementById('submit-btn').style.display = currentStep === steps.length - 1 ? 'block' : 'none';
    }
});
