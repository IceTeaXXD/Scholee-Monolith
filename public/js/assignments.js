function renderAssignments(){
    /* For elements in assignmentsData, get the data of assignment from 
     * the REST data
     */

    const element = document.getElementById("content");

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "http://localhost:5000/api/assignment")

    xhr.onload = () => {
        const res = JSON.parse(xhr.response);

        console.log(res.data);
        element.innerHTML = '';
        if (res.status === 'success') {
            assignmentsData.forEach((assignmentData) => {
                /* For elements in the assignmentsData, match the id on res.data */
                console.log(assignmentData.scholarship_id_rest)
                const matchingAssignment = res.data.find((assignment) => assignment.scholarship_id === assignmentData.scholarship_id_rest);

                if(matchingAssignment){
                    element.innerHTML += `
                    <div class="box">   
                        <h2 class="name">${matchingAssignment.assignment_name} - ${matchingAssignment.scholarship_name}</h2>
                        <div class="attribute">Description: ${matchingAssignment.assignment_description}</div>
                        <button class="btn btn-primary" onclick="openAssignment(${matchingAssignment.scholarship_id}, ${matchingAssignment.assignment_id})">Submit</button>
                    </div>
                    `;
                }
            })
            // element.innerHTML = "";

        } else {
            alertModal.style.display = "block";
        }
    };

    xhr.send()
}

function openAssignment(sid, aid){
    window.location.href=`assignments/submit?sid=${sid}&aid=${aid}`
}

document.addEventListener("DOMContentLoaded", renderAssignments);