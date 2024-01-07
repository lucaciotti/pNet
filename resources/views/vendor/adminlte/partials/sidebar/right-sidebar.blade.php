<aside class="control-sidebar control-sidebar-{{ config('adminlte.right_sidebar_theme') }}">
   
    {{-- <div class="os-padding"> --}}
        <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
            <div class="os-content" style="padding: 10px; height: 100%; width: 100%;">

                <ul class="nav nav-tabs nav-justified control-sidebar-tabs" id="controlTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="settingTab" data-toggle="pill" 
                            href="#setting" role="tab" aria-controls="setting"
                            aria-selected="false"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Admin Settings</a>
                        <a class="nav-link" id="priceTab" data-toggle="pill" 
                            href="#docs" role="tab" aria-controls="docs"
                            aria-selected="false"><i class="fa fa-file-signature"></i>&nbsp;&nbsp;Docs Settings</a>
                        <a class="nav-link" id="priceTab" data-toggle="pill" 
                            href="#price" role="tab" aria-controls="price"
                            aria-selected="false"><i class="fa fa-hand-holding-usd"></i>&nbsp;&nbsp;Price Manager</a>
                    </li>
                </ul>

                <div class="tab-content" id="controlTabContent">
                    
                    <div class="tab-pane fade active show" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                        <a href='{{ url('users') }}' class="pb-10">
                            <button type="submit" class="btn btn-block btn-outline-light">
                                <i class="fas fa-user-friends"></i>&nbsp;&nbsp;Gestione Utenti
                            </button>
                        </a>
                        <a href='{{ url('cli_users') }}' class="pb-10">
                            <button type="submit" class="btn btn-block btn-outline-light">
                                <i class="fas fa-user-tie"></i>&nbsp;&nbsp;Gestione Clienti
                            </button>
                        </a>
                        <a href='{{ url('listPrivacyAgreement') }}' class="pb-10">
                            <button type="submit" class="btn btn-block btn-outline-success">
                                <i class="fas fa-handshake"></i>&nbsp;&nbsp;Lista Consensi Privacy
                            </button>
                        </a>
                        <hr class="mb-2 bg-white">
                        <a href='{{ url('pnetLogs') }}'>
                            <button type="submit" class="btn btn-block btn-outline-warning">
                                <i class="fas fa-solar-panel"></i>&nbsp;&nbsp;Admin Log Panel
                            </button>
                        </a>
                    </div>

                    <div class="tab-pane fade show" id="docs" role="tabpanel" aria-labelledby="docs-tab">
                        <a href='{{ url('docNotes') }}' class="pb-10">
                            <button type="submit" class="btn btn-block btn-outline-light">
                                <i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Note su Documenti
                            </button>
                        </a>
                        <a href='{{ url('infoVettori') }}' class="pb-10">
                            <button type="submit" class="btn btn-block btn-outline-light">
                                <i class="fas fa-truck"></i>&nbsp;&nbsp;Gestione Vettori
                            </button>
                        </a>
                        <hr class="mb-2 bg-white">
                        <a href='{{ url('ddtToSend') }}' class="pb-10">
                            <button type="submit" class="btn btn-block btn-outline-warning">
                                <i class="fas fa-at"></i>&nbsp;&nbsp;Ddt da Inviare
                            </button>
                        </a>
                    </div>

                    <div class="tab-pane fade show" id="price" role="tabpanel" aria-labelledby="price-tab">
                        <a href='{{ url('manage-prices') }}'>
                            <button type="submit" class="btn btn-block btn-outline-light">
                                <i class="fas fa-hand-holding-usd"></i>&nbsp;&nbsp;Price Manager
                            </button>
                        </a>
                        <hr class="mb-2 bg-white">
                        <a href='{{ url('matriceprezzi') }}'>
                            <button type="submit" class="btn btn-block btn-outline-light">
                                <i class="fas fa-hand-holding-usd"></i>&nbsp;&nbsp;Matrice Prezzi
                            </button>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    {{-- </div> --}}

</aside>
