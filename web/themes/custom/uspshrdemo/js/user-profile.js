jQuery("#edit-group-profile-general .details-wrapper").prepend('<div class="profile-group"></div>');
jQuery(".profile-group").append('<h2 class="tabTitle">Basic Information</h2>');
jQuery(".profile-group").append(jQuery(".main-content .profile .field--name-user-picture"));
jQuery(".profile-group").append('<div class="profile-name"></div>');
jQuery(".profile-group .profile-name").append(jQuery(".field--name-field-profile-first-name"));
jQuery(".profile-group .profile-name").append(jQuery(".field--name-field-profile-last-name"));
jQuery(".profile-group").append(jQuery(".field--name-field-profile-title"));

