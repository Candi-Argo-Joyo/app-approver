<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item">
                    <a class="sidebar-link sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <i data-feather="home" class="feather-icon"></i><span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Master</span></li>
                <li class="sidebar-item  <?= isset($selected) ? ($selected == 'memo' ? 'selected' : ($selected == 'form_builder' ? 'selected' : ($selected == 'preview' ? 'selected' : ''))) : '' ?>">
                    <a class="sidebar-link has-arrow <?= isset($selected) ? ($selected == 'memo' ? 'active' : '') : '' ?>" href="javascript:void(0)" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Master Data
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse  first-level base-level-line <?= isset($selected) ? ($selected == 'memo' ? 'in' : ($selected == 'form_builder' ? 'in' : ($selected == 'preview' ? 'in' : ''))) : '' ?>">
                        <li class="sidebar-item">
                            <a href="{{ route('dealer') }}" class="sidebar-link">
                                <span class="hide-menu"> Dealer </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('sales') }}" class="sidebar-link">
                                <span class="hide-menu"> Sales </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('divisi') }}" class="sidebar-link">
                                <span class="hide-menu"> Divisi </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('digitalAsign') }}" class="sidebar-link">
                                <span class="hide-menu"> Digital Assign </span>
                            </a>
                        </li>
                        <li class="sidebar-item <?= isset($selected) ? ($selected == 'form_builder' ? 'active' : ($selected == 'preview' ? 'active' : '')) : '' ?>">
                            <a href="{{ route('formBuilder') }}" class="sidebar-link <?= isset($selected) ? ($selected == 'form_builder' ? 'active' : ($selected == 'preview' ? 'active' : '')) : '' ?>">
                                <span class="hide-menu"> Form Builder </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Credit</span></li>
                <li class="sidebar-item <?= isset($selected) ? ($selected == 'kredit' ? 'selected' : '') : '' ?>">
                    <a class="sidebar-link has-arrow <?= isset($selected) ? ($selected == 'kredit' ? 'active' : '') : '' ?>" href="javascript:void(0)" aria-expanded="false">
                        <i data-feather="file-text" class="feather-icon"></i><span class="hide-menu">Credit Transaction
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level base-level-line <?= isset($selected) ? ($selected == 'kredit' ? 'in' : '') : '' ?>">
                        <li class="sidebar-item">
                            <a href="{{ route('entryKredit') }}" class="sidebar-link">
                                <span class="hide-menu"> Entry Kredit </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('knowledge') }}" class="sidebar-link">
                                <span class="hide-menu"> Acknowledge by </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('approver1') }}" class="sidebar-link">
                                <span class="hide-menu"> Approver 1 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('approver2') }}" class="sidebar-link">
                                <span class="hide-menu"> Approver 2 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('approver3') }}" class="sidebar-link">
                                <span class="hide-menu"> Approver 3 </span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('dataKredit') }}" class="sidebar-link">
                                <span class="hide-menu"> Data Kredit </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="list-divider"></li>
                <li class="nav-small-cap"><span class="hide-menu">Memo</span></li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('createMemo') }}" aria-expanded="false">
                        <i data-feather="file-plus" class="feather-icon"></i><span class="hide-menu">Create
                            Memo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('approvalMemo') }}" aria-expanded="false">
                        <i data-feather="check-circle" class="feather-icon"></i><span class="hide-menu">Approval
                            Memo</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dataMemo') }}" aria-expanded="false">
                        <i data-feather="book" class="feather-icon"></i><span class="hide-menu">Data Memo</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>