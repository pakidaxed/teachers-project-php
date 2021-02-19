/**
 * Simple JS fetch to receive data from backend to show the list of existing projects
 */
function checkForProjects() {
    fetch('http://localhost/api/')
        .then(response => response.json())
        .then(data => {
            const projectsTable = document.getElementById('projects_list')
            projectsTable.innerHTML = ''
            if (data === null) {
                const p_element = document.createElement('p')
                p_element.textContent = 'No projects added yet.'
                projectsTable.appendChild(p_element)
            } else {
                const projects = data
                const theForm = document.createElement('form')
                theForm.id = 'projects'
                theForm.method = 'post'
                theForm.action = 'project.php'
                const productIdHidden = document.createElement('input')
                productIdHidden.type = 'hidden'
                productIdHidden.name = 'product_id'
                productIdHidden.value = '0'
                theForm.appendChild(productIdHidden)
                projectsTable.appendChild(theForm)
                projects.forEach(project => {
                    const projectItem = document.createElement('p')
                    projectItem.classList.add('projects_list')
                    projectItem.id = project.id
                    projectItem.textContent = project.project_name
                    const groups = document.createElement('span')
                    groups.textContent = ' (' + project.groups_total + ' groups)'
                    projectItem.appendChild(groups)
                    projectsTable.appendChild(projectItem)
                })
                document.querySelector('#projects_list')
                    .addEventListener("click", (e) => {
                        productIdHidden.value = e.target.id
                        theForm.submit()
                    })
            }
        })
}

function closeModal() {
    document.getElementById('modal').style.display = 'none'
    document.getElementById('projects').reset()
}

const theForm = document.getElementById('submitBtn')
theForm.addEventListener('click', e => {
    e.preventDefault()
    const projectName = document.getElementById('project_name').value
    const groupsTotal = document.getElementById('groups_total').value
    const studentsPerGroup = document.getElementById('students_per_group').value

    fetch("http://localhost/api/", {
        method: "POST",

        body: JSON.stringify({
            "project_name": projectName.trim(),
            "groups_total": groupsTotal.trim(),
            "students_per_group": studentsPerGroup.trim()
        })
    }).then(response => {
        return response.json()
    })
        .then(data => {
                console.log(data.message)
                setTimeout(reloadPage, 1900)
                setTimeout(closeModal, 2000)
                document.querySelector('.new-project-content').textContent = 'Project added successfully'
            }
        ).catch(() => {
            document.getElementById('error').textContent = 'Please check the project name and try again'
        }
    )
})

document.querySelector('.add-project-span').addEventListener('click', (e) => {
    document.getElementById('modal').style.display = 'flex'
})

function reloadPage() {
    location.reload()
}