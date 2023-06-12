<div id="sideNav_div" class="themeColor hide-scrollbar" style="margin-left:-14px;margin-top:3px;padding-top: 10px">
    <div id="imageDiv" class="text-center">
        <label><img src="<?=((!empty($studentData['stdimage'])?$studentData['stdimage']:$configurationData['school_logo']))?>" alt=""></label>
        <label id="name" title="<?=$studentData['stdname']?>"><b><?=cutstring($studentData['stdname'],25)?></b></label>
    </div>
    <div id="contentDiv" class="small_font">
        <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="index.php">
            <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="evaluation.php">
            <i class="fas fa-book-reader"></i> Academic Evaluation
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="student-finance.php">
            <i class="fas fa-coins"></i> Student Finance
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/shuffle.php">
            <i class="fas fa-poll"></i> Shuffle
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/school/admin/salaries.php">
            <i class="fas fa-coins"></i> Salaries
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/school/admin/expenditure.php">
            <i class="fas fa-coins"></i> Expenditure
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/school/admin/banks.php">
            <i class="fas fa-coins"></i> Banks
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/school/admin/dates.php">
            <i class="far fa-calendar-alt"></i> Term Dates
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/books.php">
            <i class="fas fa-book"></i> Books
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/schooldocuments.php">
            <i class="fas fa-file-alt"></i>  School Documents
            </a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="../admin/applications.php">
            <i class="fas fa-file-alt"></i>  Online Applications
            <span class="badge label-pill badge-success notifications_count"></span>
            </a>
        </li>  
        <li class="nav-item">
            <a class="nav-link" href="messages.php">
            <i class="fas fa-comment-dots"></i>  Messages
            <span class="badge label-pill badge-success message_count"></span>
            </a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="complains.php">
            <i class="fas fa-comment-dots"></i>  Complains
            <span class="badge label-pill badge-success complains_count"></span>
            </a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="gallery.php">
            <i class="far fa-images"></i></i> Gallery Images
            </a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="siteimages.php">
            <i class="far fa-images"></i></i> Website Images
            </a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="events.php">
            <i class="far fa-calendar-alt"></i> News & Events
            </a>
        </li> 
            <li class="nav-item">
            <a class="nav-link" href="/school/admin/configuration.php">
            <i class="fas fa-cog"></i> System Configuration
            </a>
        </li> 
        </ul>
    </div>
    <div id="footerDiv" class="text-center exsmall_font">
        <label>&copyCopyright: <?=date('Y')?> Wekesir Systems</label>
    </div>
</div>