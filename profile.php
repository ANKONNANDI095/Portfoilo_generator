<?php
session_start();
include("connect.php");

if (!isset($_SESSION['email'])) {
  header("Location: ../login.php");
  exit();
}

if (!isset($_SESSION['user_id'])) {
  die("User ID not found in session. Please log in again.");
}

$user_id = $_SESSION['user_id'];

// Fetch user's data
$personal_info_query = "SELECT * FROM personal_info WHERE user_id = '$user_id'";
$personal_info_result = mysqli_query($conn, $personal_info_query);
$personal_info = mysqli_fetch_assoc($personal_info_result);

$skills_query = "SELECT * FROM skills WHERE user_id = '$user_id'";
$skills_result = mysqli_query($conn, $skills_query);
$skills = mysqli_fetch_assoc($skills_result);

$academic_query = "SELECT * FROM academic_background WHERE user_id = '$user_id'";
$academic_result = mysqli_query($conn, $academic_query);
$academic = mysqli_fetch_assoc($academic_result);

$experience_query = "SELECT * FROM professional_experience WHERE user_id = '$user_id'";
$experience_result = mysqli_query($conn, $experience_query);
$experience = mysqli_fetch_assoc($experience_result);

$projects_query = "SELECT * FROM projects_publications WHERE user_id = '$user_id'";
$projects_result = mysqli_query($conn, $projects_query);
$projects = mysqli_fetch_assoc($projects_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Include jsPDF Library -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #f4f4f4;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .section {
      margin-bottom: 20px;
    }

    .section h2 {
      margin-bottom: 10px;
      color: #333;
      font-size: 18px;
      border-bottom: 2px solid #007bff;
      /* Underline for section headings */
      padding-bottom: 5px;
    }

    .section input,
    .section textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .section textarea {
      resize: vertical;
      min-height: 100px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-align: center;
    }

    .btn:hover {
      background: #0056b3;
    }

    .download-btn {
      background: #28a745;
      margin-left: 10px;
    }

    .download-btn:hover {
      background: #218838;
    }

    img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .cv-section {
      margin-bottom: 20px;
    }

    .cv-section h3 {
      font-size: 16px;
      color: #007bff;
      /* Blue color for subheadings */
      margin-bottom: 5px;
    }

    .cv-section p {
      font-size: 14px;
      color: #555;
      margin-bottom: 10px;
    }

    .cv-section ul {
      list-style-type: none;
      padding-left: 0;
    }

    .cv-section ul li {
      margin-bottom: 5px;
      font-size: 14px;
      color: #555;
    }

    .two-column {
      display: flex;
      justify-content: space-between;
    }

    .two-column .column {
      width: 48%;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Your Profile</h1>
    <form method="POST" action="profile.php">
      <!-- Personal Information -->
      <div class="section">
        <h2>Personal Information</h2>
        <?php if (!empty($personal_info['profile_picture'])): ?>
          <img src="<?php echo $personal_info['profile_picture']; ?>" alt="Profile Picture" id="profile-picture">
        <?php else: ?>
          <p>No profile picture uploaded.</p>
        <?php endif; ?>
        <input type="text" name="fullName" value="<?php echo $personal_info['fullName']; ?>" placeholder="Full Name"
          required>
        <input type="text" name="phone" value="<?php echo $personal_info['phone']; ?>" placeholder="Phone Number"
          required>
        <textarea name="bio" placeholder="Bio" required><?php echo $personal_info['bio']; ?></textarea>
      </div>

      <!-- Skills -->
      <div class="section">
        <h2>Skills</h2>
        <textarea name="soft_skills" placeholder="Soft Skills" required><?php echo $skills['soft_skills']; ?></textarea>
        <textarea name="technical_skills" placeholder="Technical Skills"
          required><?php echo $skills['technical_skills']; ?></textarea>
      </div>

      <!-- Academic Background -->
      <div class="section">
        <h2>Academic Background</h2>
        <input type="text" name="institution" value="<?php echo $academic['institution']; ?>" placeholder="Institution"
          required>
        <input type="text" name="degree" value="<?php echo $academic['degree']; ?>" placeholder="Degree" required>
        <input type="text" name="graduation_year" value="<?php echo $academic['graduation_year']; ?>"
          placeholder="Graduation Year" required>
        <input type="text" name="grade" value="<?php echo $academic['grade']; ?>" placeholder="Grade" required>
      </div>

      <!-- Professional Experience -->
      <div class="section">
        <h2>Professional Experience</h2>
        <input type="text" name="company_name" value="<?php echo $experience['company_name']; ?>"
          placeholder="Company Name" required>
        <input type="text" name="job_title" value="<?php echo $experience['job_title']; ?>" placeholder="Job Title"
          required>
        <input type="text" name="job_duration" value="<?php echo $experience['job_duration']; ?>"
          placeholder="Job Duration" required>
        <textarea name="responsibilities" placeholder="Responsibilities"
          required><?php echo $experience['responsibilities']; ?></textarea>
      </div>

      <!-- Projects & Publications -->
      <div class="section">
        <h2>Projects & Publications</h2>
        <input type="text" name="title" value="<?php echo $projects['title']; ?>" placeholder="Title" required>
        <textarea name="description" placeholder="Description"
          required><?php echo $projects['description']; ?></textarea>
        <input type="text" name="link" value="<?php echo $projects['link']; ?>" placeholder="Link (Optional)">
      </div>

      <!-- Save and Download Buttons -->
      <button type="submit" class="btn">Save Changes</button>
      <button type="button" class="btn download-btn" onclick="generatePDF()">Download as PDF</button>
    </form>
  </div>

  <script>
    // Function to generate and download PDF
    function generatePDF() {
      const { jsPDF } = window.jspdf;

      // Create a data object with the user's information
      const data = {
        name: "<?php echo $personal_info['fullName']; ?>",
        phone: "<?php echo $personal_info['phone']; ?>",
        email: "<?php echo $_SESSION['email']; ?>",
        soft_skills: "<?php echo $skills['soft_skills']; ?>",
        technical_skills: "<?php echo $skills['technical_skills']; ?>",
        career_objective: "<?php echo $personal_info['bio']; ?>",
        education: {
          institution: "<?php echo $academic['institution']; ?>",
          degree: "<?php echo $academic['degree']; ?>",
          graduation_year: "<?php echo $academic['graduation_year']; ?>",
        },
        work_experience: [
          {
            company: "<?php echo $experience['company_name']; ?>",
            title: "<?php echo $experience['job_title']; ?>",
            duration: "<?php echo $experience['job_duration']; ?>",
            responsibilities: "<?php echo $experience['responsibilities']; ?>",
          },
        ],
        projects: [
          {
            title: "<?php echo $projects['title']; ?>",
            description: "<?php echo $projects['description']; ?>",
            link: "<?php echo $projects['link']; ?>",
          },
        ],
      };

      // Call the generatePDF function with the data
      generatePDFWithData(data);
    }

    // Function to generate PDF with data
    function generatePDFWithData(data) {
      const { jsPDF } = window.jspdf;
      const doc = new jsPDF("p", "pt", "a4");

      const pageWidth = doc.internal.pageSize.getWidth();
      const pageHeight = doc.internal.pageSize.getHeight();
      const sidebarWidth = 180;
      const margin = 40;

      const primaryColor = "#00BCD4";
      const textColor = "#333";
      const sidebarBg = "#E0F7FA";

      doc.setFillColor(sidebarBg);
      doc.rect(0, 0, sidebarWidth, pageHeight, "F");

      let sideY = margin;

      // === PROFILE IMAGE ===
      const profilePicture = document.getElementById("profile-picture");
      if (profilePicture && profilePicture.src) {
        doc.addImage(profilePicture.src, "JPEG", 40, sideY, 100, 100);
        sideY += 120;
      }

      doc.setFontSize(14);
      doc.setTextColor(textColor);

      // === CONTACT INFO ===
      doc.text("Contact", 40, sideY);
      doc.setDrawColor("#aaa");
      doc.setLineWidth(1);
      doc.line(40, sideY + 5, sidebarWidth - 20, sideY + 5);
      sideY += 20;

      doc.setFontSize(10);
      doc.text(`Phone: ${data.phone}`, 40, sideY);
      sideY += 15;
      doc.text(`Email: ${data.email}`, 40, sideY);
      sideY += 25;

      // === SKILLS ===
      doc.setFontSize(14);
      doc.text("Skills", 40, sideY);
      doc.line(40, sideY + 5, sidebarWidth - 20, sideY + 5);
      sideY += 20;

      doc.setFontSize(10);
      doc.text("Soft Skills:", 40, sideY);
      sideY += 15;

      const softSkillLines = doc.splitTextToSize(data.soft_skills, sidebarWidth - 50);
      doc.text(softSkillLines, 40, sideY);
      sideY += softSkillLines.length * 12 + 10;

      doc.text("Technical Skills:", 40, sideY);
      sideY += 15;

      const techSkillLines = doc.splitTextToSize(data.technical_skills, sidebarWidth - 50);
      doc.text(techSkillLines, 40, sideY);
      sideY += techSkillLines.length * 12 + 20;

      // === MAIN CONTENT ===
      const contentX = sidebarWidth + 40;
      let contentY = margin;

      // NAME
      doc.setFontSize(24);
      doc.setTextColor(textColor);
      doc.text(data.name, contentX, contentY);
      contentY += 40;

      // OBJECTIVE
      doc.setFontSize(14);
      doc.setTextColor(primaryColor);
      doc.text("OBJECTIVE", contentX, contentY);
      doc.line(contentX, contentY + 5, contentX + 200, contentY + 5);
      contentY += 25;

      doc.setFontSize(12);
      doc.setTextColor(textColor);
      const objectiveLines = doc.splitTextToSize(data.career_objective, pageWidth - sidebarWidth - 80);
      doc.text(objectiveLines, contentX, contentY);
      contentY += objectiveLines.length * 15 + 20;

      // EDUCATION
      doc.setFontSize(14);
      doc.setTextColor(primaryColor);
      doc.text("EDUCATION", contentX, contentY);
      doc.line(contentX, contentY + 5, contentX + 200, contentY + 5);
      contentY += 25;

      doc.setFontSize(12);
      doc.setTextColor(textColor);
      doc.text(data.education.institution, contentX, contentY);
      contentY += 15;
      doc.text(`Degree: ${data.education.degree}`, contentX, contentY);
      contentY += 15;
      doc.text(`Graduation Year: ${data.education.graduation_year}`, contentX, contentY);
      contentY += 30;

      // WORK EXPERIENCE
      doc.setFontSize(14);
      doc.setTextColor(primaryColor);
      doc.text("WORK EXPERIENCE", contentX, contentY);
      doc.line(contentX, contentY + 5, contentX + 200, contentY + 5);
      contentY += 25;

      doc.setFontSize(12);
      doc.setTextColor(textColor);
      data.work_experience.forEach((job) => {
        doc.text(job.company, contentX, contentY);
        contentY += 15;
        doc.text(`Job Title: ${job.title}`, contentX, contentY);
        contentY += 15;
        doc.text(`Duration: ${job.duration}`, contentX, contentY);
        contentY += 15;

        const respLines = doc.splitTextToSize(job.responsibilities, pageWidth - sidebarWidth - 80);
        doc.text(`Responsibilities:`, contentX, contentY);
        contentY += 15;
        doc.text(respLines, contentX + 15, contentY);
        contentY += respLines.length * 15 + 20;
      });

      // PROJECTS & PUBLICATIONS
      doc.setFontSize(14);
      doc.setTextColor(primaryColor);
      doc.text("PROJECTS & PUBLICATIONS", contentX, contentY);
      doc.line(contentX, contentY + 5, contentX + 200, contentY + 5);
      contentY += 25;

      doc.setFontSize(12);
      doc.setTextColor(textColor);
      data.projects.forEach((project) => {
        doc.text(project.title, contentX, contentY);
        contentY += 15;

        const projDescLines = doc.splitTextToSize(project.description, pageWidth - sidebarWidth - 80);
        doc.text(projDescLines, contentX, contentY);
        contentY += projDescLines.length * 15;

        doc.text(`Link: ${project.link}`, contentX, contentY);
        contentY += 30;
      });

      doc.save("Professional_CV.pdf");
    }
  </script>
</body>

</html>