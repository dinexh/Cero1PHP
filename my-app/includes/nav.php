<?php
?>
<link rel="stylesheet" href="/includes/nav.css"> 
<nav>
    <div class="nav-in">
        <div class="nav-in-one">
            <h1>Zero<span>One</span> Portal</h1>
        </div>
        <div class="nav-in-two-link">
            <label for="">Quick Links</label>
            <select id="navSelect" aria-label="Navigation Menu"> 
                <option value="">Default</option>
                <option value="/pages/register/register.php">Core Recruitment</option>
                <option value="">Club Recruitment</option>
                <option value="">Club Feedback</option>
            </select>
        </div>
        <div class="nav-in-two">
            <div class="nav-in-two-in">
                <p>Join the Community</p>
            </div>
        </div>
    </div>
</nav>
<script>
    document.getElementById("navSelect").addEventListener("change", function (event) {
        event.preventDefault(); // Prevent any default form behavior
        const selectedOption = this.value;
        if (selectedOption) {
            window.location.href = selectedOption; // Navigate to the selected option URL
        }
    });
</script>
