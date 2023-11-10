function renderAssignments(){
    /* For elements in assignmentsData, get the data of assignment from 
     * the REST data
     */

    const element = document.getElementById("content");

    const xhr = new XMLHttpRequest();
    xhr.open("GET", `http://localhost:5000/api/assignment/${sid}`)

    xhr.onload = () => {
        const res = JSON.parse(xhr.response);

        console.log(res.data);
        element.innerHTML = '';
        if (res.status === 'success') {
            if(res.data.length === 0){
                element.innerHTML = "No Assignments Found";
            }else{
                res.data.forEach(el => {
                    element.innerHTML += `
                    <div class="box">   
                        <h2 class="name">${el.assignment_name}</h2>
                        <button class="btn btn-primary" onclick="openAssignment(${el.scholarship_id}, ${el.assignment_id})">Submit</button>
                    </div>
                    `;
                });
            }
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