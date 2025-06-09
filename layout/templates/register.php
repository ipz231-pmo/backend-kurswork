<div
    id="register-layout"
    class="fixed-top vh-100 vw-100 d-none d-flex align-items-center justify-content-center">
    <div class="card shadow-sm mx-auto" style="max-width: 500px;">
        <div class="card-header">
            <h2 class="h4 text-center m-0 py-2">Create an Account</h2>
        </div>
        <div class="card-body p-4">
            <form id="registration-form">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="register-name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="register-name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="register-familyName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="register-familyName" required>
                    </div>
                </div>
                
                <div class="mb-3 mt-3">
                    <label for="register-email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="register-email" required>
                </div>
                
                <div class="mb-3">
                    <label for="register-password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="register-password" required>
                </div>
                
                <div class="mb-4">
                    <label for="register-confirmPassword" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirmPassword" required>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Register</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center">
            <small>Already have an account? Use the 'Log in' button in the header.</small>
        </div>
    </div>
</div>