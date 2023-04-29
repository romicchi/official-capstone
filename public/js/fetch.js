const collegeSelect = document.getElementById('college');
const courseSelect = document.getElementById('courseSelect');
const subjectSelect = document.getElementById('subjectSelect');

collegeSelect.addEventListener('change', () => {
    const collegeId = collegeSelect.value;
    if (collegeId) {
        fetch(`/api/courses/${collegeId}`)
            .then(response => response.json())
            .then(courses => {
                // Clear existing options
                courseSelect.innerHTML = '<option value="">Select Course</option>';

                // Add fetched courses as options
                courses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.subjectName;
                    courseSelect.appendChild(option);
                });

                // Show the Course select element
                document.getElementById('courseContainer').style.display = 'block';

                // Clear the subjects dropdown
                subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                // Hide the Subject select element
                document.getElementById('subjectContainer').style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        // Clear the courses and subjects dropdowns if no college is selected
        courseSelect.innerHTML = '<option value="">Select Course</option>';
        subjectSelect.innerHTML = '<option value="">Select Subject</option>';

        // Hide the Course and Subject select elements
        document.getElementById('courseContainer').style.display = 'none';
        document.getElementById('subjectContainer').style.display = 'none';
    }
});

courseSelect.addEventListener('change', () => {
const courseId = courseSelect.value;
if (courseId) {
fetch(`/api/subjects/${courseId}`)
  .then(response => response.json())
  .then(subjects => {
    // Clear existing options
    subjectSelect.innerHTML = '<option value="">Select Subject</option>';

    // Add fetched subjects as options
    subjects.forEach(subject => {
      const option = document.createElement('option');
      option.value = subject.id;
      option.textContent = subject.subjectName;
      subjectSelect.appendChild(option);
    });

    // Show the Subject select element
    document.getElementById('subjectContainer').style.display = 'block';
  })
  .catch(error => {
    console.error('Error:', error);
  });
} else {
// Clear the subjects dropdown if no course is selected
subjectSelect.innerHTML = '<option value="">Select Subject</option>';

// Hide the Subject select element
document.getElementById('subjectContainer').style.display = 'none';
}
});