<h1>IT Asset Tracker - Efficient Management of Your IT Equipment</h1>

IT Asset Tracker is a powerful tool designed to streamline the management of your company's IT assets. 
With the ability to add new devices and manage existing ones, administrators have complete control over the lifecycle of company hardware. 

Easily edit the current user of any device and track when equipment becomes eligible for replacement.
The app also calculates the efficiency of device usage, giving IT teams valuable insights into whether it’s necessary to replace hardware. 
For example, if a device’s usage is below 50%, it might not require immediate replacement.

IT Asset Tracker allows for customizable replacement intervals for different types of devices
 such as laptops, desktops, and phones, ensuring that each asset is managed according to its specific usage pattern. 
This way, your IT department can make informed, cost-effective decisions while maintaining optimal operational performance.

Maximize your IT infrastructure efficiency with IT Asset Tracker!

<h1>Login View</h1>

On this page, you can log in as an existing user or, if you don't have an account, easily navigate to the registration form.

### Existing Users:
- Enter your email and password to access your account.

### New Users:
- If you don’t have an account, simply click the registration link to create one.

### Error Handling:
- If you enter an email that is not registered in our system, you will receive a notification informing you that the email is not found.
- If the password you provide is incorrect, a message will alert you to check your credentials.

<h2>Mobile</h2>
<div style="text-align: center;">
  <img src="/images/redme/login%20mobile.png" style="width: 40%; height: auto;" />
</div>

<h3>Desktop</h3>
<div style="text-align: center;">
  <img src="/images/redme/login.png" style="width: 90%; height: auto;" />
</div>


<h1>Sign up View</h1>



To create a new account, please provide all the required information. Each field is mandatory for successful registration.

### Key Points:
- **Complete All Fields:** Ensure that all necessary data, including your name, email, and password, is filled out.
- **Manager Validation:** If you enter the name of a manager that does not exist in the system, the account will not be created.
- **Email Validation:** If the email you provide is already associated with an existing account, registration will be blocked, and you will receive a notification to use a different email address.

Make sure that all information is accurate to successfully create your account.

<h3>Mobile</h3>
<div style="text-align: center;">
  <img src="/images/redme/signUp_mobile.png" style="width: 40%; height: auto;" />
</div>

<h3>Desktop</h3>
<div style="text-align: center;">
  <img src="/images/redme/signUp.png" style="width: 90%; height: auto;" />
</div>



<h1>User View</h1>

In the **User View**, logged-in users with standard permissions can access detailed information about the devices assigned to them.

### Key Features:
- **Device Information:** View all details about the devices currently assigned to you. If you have multiple devices, all of them will be listed.
- **Productivity Usage:** See the percentage of productive usage of each device during its depreciation period.
- **Device Replacement:** Get notified about the exact date when you are eligible for a replacement with a new device.

This view provides users with all the essential data they need to monitor their assigned devices and stay informed about their lifecycle.

<h3>Mobile</h3>
<div style="text-align: center;">
  <img src="/images/redme/userView%20mobile.png" style="width: 40%; height: auto;" />
</div>

<h3>Desktop</h3>
<div style="text-align: center;">
  <img src="/images/redme/userView.png" style="width: 90%; height: auto;" />
</div>

<h1>Admin View</h1>

When logged in with an admin account, you will be redirected to a comprehensive list of all devices in the system. As an admin, you have full control over device management.

### Key Features:
- **Device Management:** View and manage all devices in the system.
- **Sorting:** Easily sort devices by type, including desktop, laptop, and phone.
- **Search Functionality:** Quickly find devices by searching for their serial number.
- **Edit and Delete:** Admins can edit device details or remove devices from the system.
- **Detailed Device View:** By clicking on a device thumbnail, you will be taken to a detailed page with all relevant information about the selected device.

This view gives administrators complete control over device inventory, providing easy access to all necessary management tools.


<h3>Mobile</h3>
<div style="text-align: center;">
  <img src="/images/redme/deviceListAdminView%20mobile.png" style="width: 40%; height: auto;" />
</div>

<h3>Desktop</h3>
<div style="text-align: center;">
  <img src="/images/redme/deviceListAdminView.png" style="width: 90%; height: auto;" />
</div>


<h1>Add Device</h1>

In the **Add Device View**, administrators can add new devices to the system by providing all necessary details about the device.

### Key Features:
- **Device Type Selection:** Start by selecting the tile that corresponds to the type of device you are adding: Laptop, Desktop, or Phone.
- **Device Details:** Fill in all required information, including:
 - **Brand**
 - **Model**
 - **Purchase Date**
 - **Primary User:** The user who will be assigned to this device.
- **Submit:** Once all fields are completed, confirm your entry to add the device to the system.

This view ensures that new devices are properly registered in the system with all relevant details for effective tracking and management.

<h3>Mobile</h3>
<div style="text-align: center;">
  <img src="/images/redme/addDevice%20mobile.png" style="width: 40%; height: auto;" />
</div>

<h3>Desktop</h3>
<div style="text-align: center;">
  <img src="/images/redme/addDevice.png" style="width: 90%; height: auto;" />
</div>


<h1>Edit Device</h1>

In the **Edit Device View**, administrators have the ability to modify the details of previously added devices. This functionality allows for accurate and up-to-date information management.

### Key Features:
- **Edit Existing Devices:** Access and edit any previously registered device in the system.
- **Editable Fields:** Modify all device details except for the device type, including:
 - **Brand**
 - **Model**
 - **Purchase Date**
 - **Primary User:** Update the user assigned to this device as needed.
- **Save Changes:** Once the necessary modifications are made, save your changes to ensure that the device information is current.

This view empowers administrators to maintain accurate records for all devices, facilitating better tracking and management throughout their lifecycle.


<h3>Mobile</h3>
<div style="text-align: center;">
  <img src="/images/redme/editDevice%20mobile.png" style="width: 40%; height: auto;" />
</div>

<h3>Desktop</h3>
<div style="text-align: center;">
  <img src="/images/redme/editDevice.png" style="width: 90%; height: auto;" />
</div>

<h1>Database structure</h1>

This application utilizes a relational database to manage and track equipment ownership and user information. The schema consists of three main tables: **`equipment`**, **`users`**, and **`ownership`**. Each table is designed to store relevant data and ensure the integrity of the relationships between the entities. Below is a detailed description of each table and its purpose.

### Tables

#### 1. **Equipment Table**

The **`equipment`** table stores information about the devices available in the system. Each device is represented by the following attributes:

- **`id`**: A unique identifier for each piece of equipment (Primary Key).
- **`type`**: The category of the device (e.g., laptop, desktop, phone).
- **`brand`**: The manufacturer of the device.
- **`model`**: The model name or number of the device.
- **`serial_number`**: The unique serial number assigned to the device.
- **`purchase_date`**: The date on which the equipment was purchased.

This table serves as the foundation for tracking the devices assigned to users.

#### 2. **Users Table**

The **`users`** table contains details about individuals who interact with the system. The key attributes include:

- **`id`**: A unique identifier for each user (Primary Key).
- **`name`**: The first name of the user.
- **`surname`**: The last name of the user.
- **`account_type`**: Specifies the type of account (e.g., admin, regular user).
- **`job_title`**: The job title of the user within the organization.
- **`department`**: The department to which the user belongs.
- **`manager`**: A reference to the user ID of the user's manager.
- **`email`**: The email address of the user (Unique).
- **`phone_number`**: The user's contact number.
- **`password`**: The hashed password for user authentication.
- **`created_at`**: Timestamp for when the user account was created.

This table enables the management of user accounts and their respective roles within the application.

#### 3. **Ownership Table**

The **`ownership`** table acts as a link between users and the equipment they are assigned. The attributes are as follows:

- **`id`**: A unique identifier for each ownership record (Primary Key).
- **`equipment_id`**: A reference to the `id` of the equipment from the **`equipment`** table.
- **`user_id`**: A reference to the `id` of the user from the **`users`** table.
- **`assigned_at`**: The timestamp when the equipment was assigned to the user (defaults to the current timestamp).
- **`returned_at`**: The timestamp when the equipment was returned, if applicable.
- **`status`**: The current status of the equipment assignment (e.g., active, returned).

This table establishes a many-to-many relationship between users and equipment, allowing the system to track which user is assigned to which device and the status of that assignment.

### Relationships

- The **`ownership`** table links **`users`** and **`equipment`** through foreign keys (`user_id` and `equipment_id`). This structure allows the application to efficiently manage device assignments and monitor their status.

<div style="text-align: center;">
  <img src="/images/redme/diagramERD.png" style="width: 90%; height: auto;" />
</div>


<h1>Technologies Used</h1>

- **PHP**: Server-side scripting language for dynamic content generation.
- **HTML/CSS**: Markup and styling languages for building the user interface.
- **JavaScript (with Fetch API)**: For asynchronous communication with the server and to dynamically update the user interface.
- **Docker**: Used to containerize the application for easy deployment and management.
- **PostgreSQL**: The relational database management system for storing data.
- **Nginx**: Web server used to serve the application.

