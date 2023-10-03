const collegeSelect = document.getElementById('college');
const disciplineSelect = document.getElementById('discipline');

collegeSelect.addEventListener('change', () => {
    const collegeId = collegeSelect.value;
    if (collegeId) {
        fetch(`/api/disciplines/${collegeId}`)
            .then(response => response.json())
            .then(disciplines => {
                // Clear existing options
                disciplineSelect.innerHTML = '<option value="">Select Discipline</option>';

                // Add fetched disciplines as options
                disciplines.forEach(discipline => {
                    const option = document.createElement('option');
                    option.value = discipline.id;
                    option.textContent = discipline.disciplineName;
                    disciplineSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        // Clear the disciplines dropdown if no college is selected
        disciplineSelect.innerHTML = '<option value="">Select Discipline</option>';
    }
});