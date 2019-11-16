
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

    confirm('Tag_id: ' + tagId + 'newTitle: ' + title);
}
/*
use for updating project title with axios
*/
function updateProjectTitle(title, projectId) {
    axios({
        method: 'PUT',
        url: '/projects/update/' + projectId,
        data: {
            title: title,
        }
    });

    confirm('projectId: ' + projectId + 'newTitle: ' + title);
}



