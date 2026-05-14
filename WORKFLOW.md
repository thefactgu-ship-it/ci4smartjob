# CI4 SmartJob - System Workflow & Process Flow

## Executive Summary

CI4 SmartJob is a full-stack employment management system that connects job seekers with employers through an organized queue-based application process. The platform handles user authentication, profile management, job applications, document generation, and automated notifications.

---

## 🔄 Core System Workflow

### 1. User Onboarding & Authentication

```
┌─────────────────────────────────────────┐
│  User Visits Application                 │
│  http://yourapp.railway.app/            │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Route: /login (GET)                    │
│  Display Login Form                     │
│  ├─ Username input                      │
│  ├─ Password input                      │
│  └─ Submit button                       │
└────────────────┬────────────────────────┘
                 │
                 ▼ (Submit)
┌─────────────────────────────────────────┐
│  Route: /authcontroller/loginauth (POST)│
│  AuthController::loginAuth()            │
│  ├─ Validate credentials                │
│  ├─ Check employee table                │
│  └─ Create session                      │
└────────────────┬────────────────────────┘
                 │
        ┌────────┴────────┐
        │                 │
        ▼                 ▼
    Success          Fail/Redirect
        │                 │
        ▼                 ▼
   Dashboard         Login Error
```

### 2. Job Seeker Profile Creation

```
┌─────────────────────────────────────────┐
│  Route: /user/ (GET)                    │
│  User::index()                          │
│  Display Job Seeker Dashboard           │
└────────────────┬────────────────────────┘
                 │
                 ├─→ View Profile Information
                 │    ├─ Personal Details
                 │    ├─ Education History
                 │    ├─ Employment Records
                 │    └─ Contact Information
                 │
                 └─→ Update Profile
                      │
                      ▼
         ┌────────────────────────────┐
         │ Routes:                    │
         │ POST /user/save            │
         │ POST /user/save_history    │
         │ POST /user/save_student    │
         └────────────────┬───────────┘
                          │
                          ▼
         ┌────────────────────────────┐
         │ Database Tables Updated    │
         │ ├─ personal_information    │
         │ ├─ job_history             │
         │ ├─ address                 │
         │ └─ educations              │
         └────────────────────────────┘
```

### 3. Company Management

```
┌─────────────────────────────────────────┐
│  Route: /company/company_list (GET)     │
│  CompanyController::index()             │
│  Display Available Companies            │
└────────────────┬────────────────────────┘
                 │
        ┌────────┼────────┐
        │        │        │
        ▼        ▼        ▼
    View All   Add New   Edit Company
    Companies  Company
        │        │        │
        └────────┼────────┘
                 │
         ┌───────┴────────┐
         │                │
         ▼                ▼
   Database Read    Database Write
   (SELECT)         (INSERT/UPDATE)
         │                │
         ▼                ▼
   company table ← company table
```

### 4. Job Application Process

```
┌─────────────────────────────────────────┐
│  Route: /home/promote (GET)             │
│  Home::promote()                        │
│  Display Available Job Promotions       │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Select Company & Apply                 │
│  Click "Apply to Company"               │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Route: /company/saveSelection (GET/POST)│
│  CompanyController::saveSelection()     │
│  Save Application Record                │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Database Operations                    │
│  1. Update personal_information         │
│     └─ Set queue_status = 'pending'    │
│                                         │
│  2. Insert into company_select         │
│     ├─ company_id (which company)      │
│     ├─ personal_id (which seeker)      │
│     ├─ status = 'pending'              │
│     └─ created_at = NOW()              │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Application in Queue                   │
│  (Awaiting Admin Review)                │
└─────────────────────────────────────────┘
```

### 5. Queue Processing & Status Updates

```
┌─────────────────────────────────────────┐
│  Admin Dashboard                        │
│  Route: /home/default (GET)             │
│  DashboardController::index()           │
│  View Pending Applications              │
└────────────────┬────────────────────────┘
                 │
                 ├─→ See Pending Queue
                 │   (from company_select)
                 │
                 └─→ Review Each Application
                      │
                      ▼
          ┌────────────────────┐
          │ Approve/Reject     │
          │ Application        │
          └────────┬───────────┘
                   │
         ┌─────────┴─────────┐
         │                   │
         ▼                   ▼
      Approved           Rejected
         │                   │
         ▼                   ▼
   Update Status         Update Status
   to 'approved'         to 'rejected'
         │                   │
         └─────────┬─────────┘
                   │
                   ▼
      ┌────────────────────────────┐
      │ Route: POST                │
      │ /home/updateStatus/:id     │
      │ Home::updateStatus()       │
      │ Update Database            │
      └────────────────────────────┘
```

### 6. Email Notifications

```
┌─────────────────────────────────────────┐
│  Event Triggered                        │
│  ├─ Application submitted               │
│  ├─ Status changed (approved/rejected)  │
│  ├─ New company added                   │
│  └─ Document generated                  │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Email Service (SMTP)                   │
│                                         │
│  Configuration:                         │
│  ├─ Host: smtp.gmail.com               │
│  ├─ Port: 587                          │
│  ├─ Security: TLS                      │
│  ├─ From: configured-email@gmail.com   │
│  └─ Auth: Gmail App Password           │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Routes:                                │
│  GET /test-email                        │
│  (Test email delivery)                  │
└────────────────┬────────────────────────┘
                 │
         ┌───────┴───────┐
         │               │
         ▼               ▼
    Email Sent      Email Failed
    (Success)       (Error Log)
```

### 7. Document Generation (PDF Resume)

```
┌─────────────────────────────────────────┐
│  Route: /generate-resume/:id (GET)      │
│  PdfController::generateResume($id)     │
│  Generate PDF from Job Seeker Data      │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Retrieve Data from Database            │
│  ├─ personal_information (seeker info)  │
│  ├─ education (school info)             │
│  ├─ job_history (experience)            │
│  ├─ employment_information (current)    │
│  └─ address (contact address)           │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  TCPDF Processing                       │
│  ├─ Create PDF document                 │
│  ├─ Add seeker information              │
│  ├─ Format education records            │
│  ├─ Add employment history              │
│  └─ Generate PDF output                 │
└────────────────┬────────────────────────┘
                 │
         ┌───────┴───────┐
         │               │
         ▼               ▼
    Download       Save File
    (Browser)      (Server)
                   public/uploads/
```

### 8. Employment Tracking

```
┌─────────────────────────────────────────┐
│  After Approval                         │
│  Seeker Gets Job Placement              │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Admin Updates Employment Record        │
│  Route: /home/details/:id (GET)         │
│  Display Employment Details Form        │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Enter Employment Information:          │
│  ├─ Company Name                        │
│  ├─ Job Position                        │
│  ├─ Salary                              │
│  ├─ Start Date                          │
│  ├─ Bank Account (if applicable)        │
│  └─ Employment Status                   │
└────────────────┬────────────────────────┘
                 │
                 ▼
┌─────────────────────────────────────────┐
│  Database Update                        │
│  INSERT into employment_information     │
│  ├─ personal_id                         │
│  ├─ job_status                          │
│  ├─ company_name                        │
│  ├─ job_position                        │
│  ├─ salary                              │
│  ├─ bank_no                             │
│  └─ created_at                          │
└────────────────┬────────────────────────┘
                 │
                 ▼
   ✅ Employment Record Complete
```

---

## 📊 Data Flow Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                       User Interface                         │
│  ├─ Login Form                                              │
│  ├─ Dashboard                                               │
│  ├─ Profile Forms                                           │
│  └─ Company Management                                      │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│              Controllers (Business Logic)                    │
│  ├─ AuthController (Login/Logout)                           │
│  ├─ User (Job Seeker Functions)                            │
│  ├─ CompanyController (Company Mgmt)                       │
│  ├─ Home (Main Dashboard)                                  │
│  ├─ PdfController (Resume Gen)                             │
│  └─ EmployeeController (Admin)                             │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│               Models (Data Access)                           │
│  ├─ PersonalInformationModel                               │
│  ├─ CompanyModel                                           │
│  ├─ EmployeeModel                                          │
│  ├─ JobHistoryModel                                        │
│  ├─ EmploymentInformationModel                             │
│  ├─ EducationModel                                         │
│  ├─ AddressModel                                           │
│  └─ CompanySelectModel                                     │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│            MySQL Database (Data Storage)                     │
│  ├─ employee table (users)                                  │
│  ├─ personal_information (seekers)                          │
│  ├─ company (companies)                                     │
│  ├─ company_select (applications)                           │
│  ├─ employment_information (placements)                     │
│  ├─ job_history (experience)                               │
│  ├─ address (locations)                                    │
│  └─ educations (education levels)                          │
└────────────────────┬────────────────────────────────────────┘
                     │
        ┌────────────┴────────────┐
        │                         │
        ▼                         ▼
   ┌─────────┐            ┌────────────┐
   │   PDF   │            │   Email    │
   │Generator│            │  Service   │
   │ (TCPDF) │            │   (SMTP)   │
   └─────────┘            └────────────┘
        │                         │
        ▼                         ▼
  PDF Files             Email Notifications
```

---

## 🗄️ Database State Transitions

### Job Seeker Status Flow

```
┌────────────────┐
│ PENDING_INPUT  │  (New seeker, entering data)
└────────┬───────┘
         │
         ▼
┌────────────────┐
│ REGISTERED     │  (Profile complete)
└────────┬───────┘
         │
         ▼
┌────────────────┐
│ APPLY_PENDING  │  (Application submitted)
└────────┬───────┘
         │
    ┌────┴────┐
    │         │
    ▼         ▼
┌────────┐ ┌──────────┐
│APPROVED│ │ REJECTED │
└────┬───┘ └──────────┘
     │
     ▼
┌────────────────┐
│ EMPLOYED       │  (Job placement confirmed)
└────────────────┘
```

### Application Status Progression

```
Queue Status:       Queue Reference:        Updated By:
─────────────────────────────────────────────────────────
  pending           REF-001               (System)
    ↓
  approved          REF-001               (Admin)
    ↓
  employed          REF-001               (HR/Admin)
    ↓
  completed         REF-001               (System)
```

---

## 🔄 Request-Response Cycle

### Example: Submit Job Application

```
1. USER ACTION
   ┌─ Clicks "Apply to Company"
   └─ Browser prepares POST request

2. HTTP REQUEST
   POST /company/saveSelection
   ├─ Method: POST
   ├─ Parameters:
   │  ├─ company_id: 5
   │  └─ personal_id: 2
   └─ Headers: Session cookie

3. ROUTING
   ┌─ Routes.php matches request
   └─ Routes to CompanyController::saveSelection()

4. CONTROLLER
   ┌─ Receive parameters
   ├─ Validate input
   ├─ Call Model methods
   └─ Return result

5. MODEL
   ┌─ company_select record exists?
   ├─ YES: Update existing
   ├─ NO: Insert new record
   └─ Return bool/array

6. DATABASE
   ┌─ Execute SQL query
   │  INSERT INTO company_select
   │  (company_id, personal_id, status, created_at)
   │  VALUES (5, 2, 'pending', NOW())
   └─ Return affected rows

7. RESPONSE
   ┌─ Controller receives result
   ├─ Prepare response data
   ├─ Call notification service (optional)
   └─ Return view/redirect

8. BROWSER
   ┌─ Receive HTTP response
   ├─ Render new page
   └─ Update UI

9. USER FEEDBACK
   ├─ Success message displayed
   ├─ Queue updated
   └─ Application recorded
```

---

## 🔐 Security Flow

```
┌────────────────────────────────────┐
│  1. Input Validation               │
│  ├─ Check data type                │
│  ├─ Verify length                  │
│  ├─ Sanitize input                 │
│  └─ Escape output                  │
└────────┬───────────────────────────┘
         │
         ▼
┌────────────────────────────────────┐
│  2. Authentication                 │
│  ├─ Check session exists           │
│  ├─ Verify user ID                 │
│  └─ Validate permissions           │
└────────┬───────────────────────────┘
         │
         ▼
┌────────────────────────────────────┐
│  3. Authorization                  │
│  ├─ Check user role (Admin/Staff)  │
│  ├─ Verify resource ownership      │
│  └─ Allow/Deny access              │
└────────┬───────────────────────────┘
         │
         ▼
┌────────────────────────────────────┐
│  4. Database Operations            │
│  ├─ Use prepared statements        │
│  ├─ Parameterized queries          │
│  └─ Prevent SQL injection          │
└────────┬───────────────────────────┘
         │
         ▼
┌────────────────────────────────────┐
│  5. Output Encoding                │
│  ├─ HTML escape                    │
│  ├─ JSON encode                    │
│  └─ URL encode                     │
└────────────────────────────────────┘
```

---

## 📈 Performance Considerations

### Database Queries
- Use indexes on frequently queried columns
- Implement query caching where applicable
- Monitor slow query logs

### File Handling
- Store large files (PDFs) outside web root if possible
- Use CDN for static assets (CSS, JS, images)
- Compress images before storage

### Sessions
- Use database for session storage at scale
- Implement session cleanup routines
- Set appropriate session timeouts

---

## 🚀 Deployment & Scaling

### Railway.app Architecture
```
┌─────────────────────────────────────┐
│  GitHub Repository (Source Control) │
└────────────────┬────────────────────┘
                 │ (Push)
                 ▼
┌─────────────────────────────────────┐
│  Railway.app                        │
│  ├─ Build Service (Nixpacks)       │
│  │  └─ Composer Install             │
│  ├─ Web Server (PHP-FPM/Apache)    │
│  │  └─ Public directory as root     │
│  ├─ MySQL Service                  │
│  │  └─ Auto-database provisioning   │
│  └─ Release Command                │
│     ├─ php spark migrate --all      │
│     └─ php spark db:seed            │
└────────────────┬────────────────────┘
                 │
                 ▼
        ┌─────────────────┐
        │  Live Website   │
        │  yourdomain.com │
        └─────────────────┘
```

---

## ✅ Workflow Summary

**Complete Application Lifecycle:**

1. **User Registration** → Personal profile created
2. **Profile Completion** → Education & address added
3. **Company Browsing** → View available companies
4. **Application** → Submit job application
5. **Queue Processing** → Admin reviews application
6. **Approval** → Status updated to 'approved'
7. **Employment Tracking** → Employment details recorded
8. **Document Export** → PDF resume generated
9. **Notifications** → Email sent to relevant parties
10. **Completion** → Record archived/marked complete

---

**Document Version**: 1.0  
**Last Updated**: May 2026  
**Status**: Complete
