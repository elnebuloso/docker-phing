<?php

namespace elnebuloso\Phing;

/**
 * Interface Properties
 */
interface Properties
{
    const PHING_COMMONS_ROOT = 'phing_commons_root';

    const PROJECT_ROOT = 'project_root';

    const PROJECT_DIR_MAIN_COMPOSER = 'project_dir_main_composer';

    const REPORT_PHPMETRICS_DIRECTORIES = 'report_phpmetrics_directories';

    const PROPERTY_GROUP_BASE = 'base';

    const PROPERTY_GROUP_CI_GIT = 'ci/git';

    const PROPERTY_GROUP_CI_GITVERSION = 'ci/gitversion';

    const PROPERTY_GROUP_CI_FILEVERSION = 'ci/fileversion';

    const PROPERTY_GROUP_DOCKER_TAG = 'docker/tag';
}
