/*

 */
function updateWorkSpaceTitle(title,workSpaceId) {
    axios({
        method: 'PUT',
        url: '/work-spaces/update/' + workSpaceId,
        data: {
            title: title,
        }
    });

    //confirm('workSpaceId: ' + workSpaceId + 'title: ' + title);
}

/*
use for updating tag title with axios
 */
function updateTagTitle(title, tagId) {
    axios({
        method: 'PUT',
        url: '/tags/update/' + tagId,
        data: {
            title: title,
        }
    });

    //confirm('Tag_id: ' + tagId + 'newTitle: ' + title);
}
/*
use for updating project title with axios
*/
function updateProjectTitle(title, projectId) {
    axios({
        method: 'PUT',
        url: '/projects/update/'+ projectId,
        data: {
            title: title,
        }
    });

   // confirm('projectId: ' + projectId + 'newTitle: ' + title);
}
/*
for updating project that associated with specific work time
 */

function updateWorkTimeProject(projectId,workTimeId) {
    axios({
        method: 'PUT',
        url: '/work-time/project/' + workTimeId,
        data: {
            projectId: projectId,
        }
    });

    //confirm('workTimeId: ' + workTimeId + 'projectId: ' + projectId);
}

function updateWorkTimeTag(tagId,workTimeId) {
    axios({
        method: 'PUT',
        url: '/work-time/tag/' + workTimeId,
        data: {
            tagId: tagId,
        }
    });

    //confirm('workTimeId: ' + workTimeId + 'tagId: ' + tagId);
}




/*
for updating work time title on page work time
 */
function updateWorkTimeTitle(title,workTimeId) {
    axios({
        method: 'PUT',
        url: '/work-time/title/' + workTimeId,
        data: {
            title: title,
        }
    });

   // confirm('workTimeId: ' + workTimeId + 'title: ' + title);
}
/*
using for
 */

function updateWorkTimeBillable(billable,workTimeId) {
    axios({
        method: 'PUT',
        url: '/work-time/billable/' + workTimeId,
        data: {
            billable: billable,
        }
    });

    //confirm('workTimeId: ' + workTimeId + 'billable: ' + billable);
}







