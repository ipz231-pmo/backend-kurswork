<?php
/**
 * @var string $title
 * @var array $currentUser
 */
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4">My Profile</h1>
            
            <form id="profile-form">
                <div id="success-message" class="alert alert-success d-none" role="alert"></div>
                <div id="error-message" class="alert alert-danger d-none" role="alert"></div>
                
                <!-- Personal Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="m-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="name" value="<?= htmlspecialchars($currentUser['name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="familyName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="familyName" value="<?= htmlspecialchars($currentUser['familyName'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" value="<?= htmlspecialchars($currentUser['email'] ?? '') ?>" required>
                        </div>
                    </div>
                </div>
                
                <!-- Optional Information Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="m-0">Contact & Shipping (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" placeholder="e.g., +380123456789" value="<?= htmlspecialchars($currentUser['phone'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="mailIndex" class="form-label">Postal Index</label>
                                <input type="text" class="form-control" id="mailIndex" placeholder="e.g., 01001" value="<?= htmlspecialchars($currentUser['mailIndex'] ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Password Change Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="m-0">Change Password</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Leave these fields blank if you do not want to change your password.</p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newPassword">
                            </div>
                            <div class="col-md-6">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmPassword">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" id="save-profile-btn" class="btn btn-primary btn-lg">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>