<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container6dkmoxE\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container6dkmoxE/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container6dkmoxE.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container6dkmoxE\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \Container6dkmoxE\srcApp_KernelDevDebugContainer([
    'container.build_hash' => '6dkmoxE',
    'container.build_id' => '4d4bbc0b',
    'container.build_time' => 1556620894,
], __DIR__.\DIRECTORY_SEPARATOR.'Container6dkmoxE');
