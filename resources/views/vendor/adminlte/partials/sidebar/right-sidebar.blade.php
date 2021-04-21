<aside class="control-sidebar control-sidebar-{{ config('adminlte.right_sidebar_theme') }}">
   
    {{-- <div class="os-padding"> --}}
        <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
            <div class="os-content" style="padding: 10px; height: 100%; width: 100%;">

                <ul class="nav nav-tabs nav-justified control-sidebar-tabs" id="controlTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="homeTab" data-toggle="pill" 
                            href="#home" role="tab" aria-controls="home"
                            aria-selected="true"><i class="fa fa-home"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="settingTab" data-toggle="pill" 
                            href="#setting" role="tab" aria-controls="setting"
                            aria-selected="false"><i class="fa fa-cogs"></i></a>
                    </li>
                </ul>

                <div class="tab-content" id="controlTabContent">
                    <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h6>Seleziona Ditta:</h6>
                        <div class="d-flex">
                            <select class="custom-select mb-3 text-light border-0 bg-white">
                                <option class="bg-primary">pNet DB</option>
                                {{-- <option class="bg-primary">Primary</option>
                                <option class="bg-secondary">Secondary</option>
                                <option class="bg-info">Info</option>
                                <option class="bg-success">Success</option>
                                <option class="bg-danger">Danger</option>
                                <option class="bg-indigo">Indigo</option>
                                <option class="bg-purple">Purple</option>
                                <option class="bg-pink">Pink</option>
                                <option class="bg-navy">Navy</option>
                                <option class="bg-lightblue">Lightblue</option>
                                <option class="bg-teal">Teal</option>
                                <option class="bg-cyan">Cyan</option>
                                <option class="bg-dark">Dark</option>
                                <option class="bg-gray-dark">Gray dark</option>
                                <option class="bg-gray">Gray</option>
                                <option class="bg-light">Light</option>
                                <option class="bg-warning">Warning</option>
                                <option class="bg-white">White</option>
                                <option class="bg-orange">Orange</option> --}}
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                        <h5>Customize AdminLTE</h5>
                        <hr class="mb-2">
                        <button type="button" class="btn btn-block btn-outline-light">
                            <i class="fas fa-users"></i> Gestione Utenti
                        </button>
                        <hr class="mb-2">
                        <a href='{{ url('laratrust') }}' type="button" class="btn btn-block btn-outline-warning">
                            <i class="fas fa-users"></i> Laratrust
                        </a>
                        <hr class="mb-2">
                        <button type="button" class="btn btn-block btn-outline-info">
                            <i class="fas fa-users"></i> Gestione Utenti
                        </button>
                        <hr class="mb-2">
                        <button type="button" class="btn btn-block btn-default">
                            <i class="fas fa-users"></i> Users
                        </button>
                        <hr class="mb-2">
                        <button type="button" class="btn btn-block btn-sm btn-default">
                            <i class="fas fa-users"></i> Users
                        </button>
                        <hr class="mb-2">
                        <a class="btn btn-app">
                            <span class="badge bg-purple">891</span>
                            <i class="fa fa-users"></i> Users
                        </a>
                        <a class="btn btn-app">
                            {{-- <span class="badge bg-purple">891</span> --}}
                            <i class="fa fa-users"></i> Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}

</aside>
