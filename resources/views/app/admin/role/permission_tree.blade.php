<div id="jstree">
    <ul>
        @foreach (Module::getModules() as $permission)
            <li id="{{ $permission->id }}">
                {{ Module::localize($permission->name) }}
                @if ($permission->hasChild($permission->id))
                    <ul>
                        @foreach ($permission->getChilds($permission->id) as $childPermission)
                            <li id="{{ $childPermission->id }}">
                                {{ Module::localize($childPermission->name) }}
                                @if ($childPermission->hasChild($childPermission->id))
                                    <ul>
                                        @foreach ($childPermission->getChilds($childPermission->id) as $grandChildPermission)
                                            <li id="{{ $grandChildPermission->id }}">
                                                {{ Module::localize($grandChildPermission->name) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>