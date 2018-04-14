<?php

use Illuminate\Database\Seeder;
use App\Site;
use App\User;
use App\Theme;
use App\Helpers\WebApps\ELearning\ConstantHelper;
use App\Helpers\WebApps\ELearning\ELearningSiteHelper;
use App\Helpers\WebApps\ELearning\CourseHelper;
use App\Page;
use App\Helpers\WebApps\ELearning\LessonHelper;
use App\Helpers\WebApps\ELearning\ExtraHelper;
use App\Helpers\WebApps\ELearning\ArticlesHelper;
use App\Helpers\WebApps\ELearning\HomePageHelper;

class ElearningSHA extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sha_admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@sha.edu.eg',
            'password' => bcrypt('password'),
            'address' => 'main'
        ]);

        $theme = Theme::where('location', 'templates.web-apps.elearning')->first();
        $site = $sha_admin->addSite('sha-elearning', $theme->id);

        
        $elearning_site_helper = new ELearningSiteHelper($site->id);
        
        $elearning_site_helper->update([
            'name' => 'SHA - ELearning',
            'logo' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FSH_LOGO.png?alt=media&token=2c3094a2-8ae0-4615-9526-1b2552d3828c'
        ]);
        
        $sha_student = User::create([
            'name' => 'Muhammad Orabi',
            'email' => '315150162@sha.edu.eg',
            'password' => bcrypt('password'),
            'address' => $site->address,
            'active' => 1
        ]);

        $elearning_site_helper->userUpdate([
            'title' => 'Student',
            'name' => 'Muhammad Orabi',
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2Fa558682b158debb6d6f49d07d854f99f-casual-male-avatar-silhouette-by-vexels.png?alt=media&token=4634eac4-bd41-4071-8411-8959ff8f5ae6'
        ], $sha_student);

        $footer = $site->constants()->where('type', 'footer')->first();
        ConstantHelper::update([
            'footer' => [
                'paragraph', 'logo', 'links'
            ],
            'links' => [
                'linkedin' => 'https://www.linkedin.com/school/shorouk-academy/',
                'facebook' => 'https://www.facebook.com/ShoroukAcademy/?ref=br_rs'
            ],
            'paragraph' => 'El Shorouk Academy is an educational academy, officially licensed by the Ministry of Higher Education and Scientific Research, located in El Shorouk city, Cairo, Egypt. It has been operating since 1995.'
        ], $footer);

        $homePage = $site->pages()->where('homePage', true)->first();
        HomePageHelper::update($homePage, [
            'sections' => ['showcase', 'articles', 'courses'],
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2Fmodels-of-elearning-for-corporate-training.jpg?alt=media&token=d8ec058a-4625-4ec9-81b0-b1167376db86',
            
        ]);

        $courses = $site->pages()->where('slug', 'courses')->first();
        $this->compilerCourse($courses);
        $this->computerOrganizationCourse($courses);

        $articles = $site->pages()->where('slug', 'articles')->first();
        $this->articles($articles);
    }
    
    public function compilerCourse($courses)
    {
        $compiler = CourseHelper::store($courses, [
            'title' => 'Compiler',
            'paragraph' => 'This course will discuss the major ideas used today in the implementation of programming language compilers, including lexical analysis, parsing, syntax-directed translation, abstract syntax trees, types and type checking, intermediate languages, dataflow analysis, program optimization.',
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2Fcompilers_tile.jpg?alt=media&token=c92a510e-b8e7-4e5b-9f8b-eecc0def9753',
            'tags' => ['CS', '4th year']
        ]);
    
        LessonHelper::store($compiler, [
            'title' => 'Introduction to Compiler',
            'paragraph' => 'Introduction of Compiler design. Compiler is a software which converts a program written in high level language (Source Language) to low level language (Object/Target/Machine Language). Cross Compiler that runs on a machine and produces a code for another machine.',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FIntroduction%20to%20Compiler-wMzQu2WlzGI.mp4?alt=media&token=b03405dc-dcc9-4c1f-b7ea-146646b99bca'
        ]);

        LessonHelper::store($compiler, [
            'title' => 'Compiler Parser',
            'paragraph' => 'A parser is a compiler or interpreter component that breaks data into smaller elements for easy translation into another language. A parser takes input in the form of a sequence of tokens or program instructions and usually builds a data structure in the form of a parse tree or an abstract syntax tree.',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FCompiler%20%20Parser%20Grammar%20%20Part1-i6DCIFpRAt8.mp4?alt=media&token=d55f2c52-4999-47aa-aa40-b4104966d646'
        ]);
    
        LessonHelper::store($compiler, [
            'title' => 'Compiler Scanner',
            'paragraph' => 'A lexer forms the first phase of a compiler frontend in modern processing. ... Lexing can be divided into two stages: the scanning, which segments the input string into syntactic units called lexemes and categorizes these into token classes; and the evaluating, which converts lexemes into processed values.',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FCompiler%20Scanner%20%20%20Part1-Jbwnc4smoCw.mp4?alt=media&token=adf3a84a-2c48-418c-84f0-f9d9ea6b4f77'
        ]);

        LessonHelper::store($compiler, [
            'title' => 'Parser Top Down Parser',
            'paragraph' => 'In computer science, top-down parsing is a parsing strategy where one first looks at the highest level of the parse tree and works down the parse tree by using the rewriting rules of a formal grammar. LL parsers are a type of parser that uses a top-down parsing strategy.',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FParser%20Top%20Down%20Parser%20%20Part%201-nQ_DfnHVmN8.mp4?alt=media&token=626f92a2-2870-46da-882f-eb2f2f5912d1'
        ]);

        LessonHelper::store($compiler, [
            'title' => 'Semantic Analyzer',
            'paragraph' => 'Semantic analysis is the task of ensuring that the declarations and statements of a program are semantically correct, i.e, that their meaning is clear and consistent with the way in which control structures and data types are supposed to be used.',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FSemantic%20Analyzer%20Part%201-RZPndqf3h68.mp4?alt=media&token=9830cacb-aa36-428c-abf1-a274a3014833'
        ]);

        LessonHelper::store($compiler, [
            'title' => ' Compilers Final Rev',
            'paragraph' => 'Final Revision',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FIntroduction%20to%20Compiler-wMzQu2WlzGI.mp4?alt=media&token=b03405dc-dcc9-4c1f-b7ea-146646b99bca'
        ]);

        ExtraHelper::createFile($compiler, [
            'title' => 'Lecture#1-introduction',
            'file' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FLecture%231-introduction.pdf?alt=media&token=af74f91e-b20d-4dba-8c32-707199fad986'
        ]);

        ExtraHelper::createFile($compiler, [
            'title' => 'Lecture#2-scanning',
            'file' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FLecture%232-scanning%20.pdf?alt=media&token=0cf70b6a-b917-4582-bf3b-3824072c5ded'
        ]);

        ExtraHelper::createFile($compiler, [
            'title' => 'Lecture#3-context-part1',
            'file' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FLecture%233-context-part1.pdf?alt=media&token=2af27bf9-22e6-4888-8136-104790cc4f65'
        ]);

        ExtraHelper::createFile($compiler, [
            'title' => 'Lecture#4-context-part2',
            'file' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FLecture%234-context-part2.pdf?alt=media&token=7d31a055-df0f-47a4-922a-3eb49c227ae0'
        ]);
    }

    public function computerOrganizationCourse($courses)
    {
        $co = CourseHelper::store($courses, [
            'title' => 'Computer Organization',
            'paragraph' => 'In computer engineering, computer architecture is a set of rules and methods that describe the functionality, organization, and implementation of computer systems. Some definitions of architecture define it as describing the capabilities and programming model of a computer but not a particular implementation.',
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2F6.004.3x_378x225.jpg?alt=media&token=51b0c5a8-1e15-432a-ace2-31c8b29dfd75',
            'tags' => ['CS', '3rd']
        ]);

        LessonHelper::store($co, [
            'title' => 'Memory Organization and Addressing',
            'paragraph' => 'In computing, a memory address is a reference to a specific memory location used at various levels by software and hardware. Memory addresses are fixed-length sequences of digits conventionally displayed and manipulated as unsigned integers.',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2F4%206%20Memory%20Organization%20and%20Addressing%20-%20Computer%20Organization%20and%20Architecture-7GDMxH1iiTI.mp4?alt=media&token=c0577dfd-c113-4cb8-84d4-a433ddf6bba7'
        ]);

        LessonHelper::store($co, [
            'title' => 'MARIE Architecture',
            'paragraph' => 'MARIE ( Machine Architecture that is Really Intuitive and Easy ) is a machine architecture and assembly language served only for educational purposes from The Essentials of Computer Organization and Architecture (Linda Null, Julia Lobur). ',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2F4%208%20MARIE%20Architecture%20-%20Computer%20Organization%20and%20Architecture-nBdk7IV4K-U.mp4?alt=media&token=e82a6342-6ca4-4bf4-9441-8523bf64bcb8'
        ]);

        LessonHelper::store($co, [
            'title' => 'Examples of Instruction Decoding',
            'paragraph' => 'An instruction cycle is the basic operational process of a computer. It is the process by which a computer retrieves a program instruction from its memory, determines what actions the instruction dictates, and carries out those actions',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FExamples%20of%20Instruction%20Decoding%20-%20Computer%20Organization%20and%20Architecture-VHfwqmssq38.mp4?alt=media&token=0d6f5e94-6196-4bd1-a2f8-50a59c96bd50'
        ]);

        LessonHelper::store($co, [
            'title' => 'Sequential Circuit and some examples',
            'paragraph' => 'Now sequential circuits use memory and thus there output depends on current input plus previous output. ... Examples of combinational circuits are full adder, multiplexer, decoder , encoder etc. ',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FSequential%20Circuit%20and%20some%20examples%20-%20Computer%20Organization%20and%20Architecture-EhTRSR6iNBc.mp4?alt=media&token=234638ed-cd04-4e61-b90f-ca58e36a24a6'
        ]);

        LessonHelper::store($co, [
            'title' => 'Write Assembly Program and Subroutine MARIE',
            'paragraph' => 'Write a subroutine in MARIE assembly that multiplies two values where the arguments for this subroutine are two pointers(each pointing to a value). The routine, multiply(a,b), performs *a x *b where a s value is the address storing the value being multiplied(* a uses a s contents to retrieve the value being multiplied)',
            'video' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2FWrite%20Assembly%20Program%20and%20Subroutine%20MARIE%20-%20Computer%20Organization%20and%20Architecture-CEbAPdBhiPM.mp4?alt=media&token=aa7b7dcf-24a6-4d7a-aacc-83366998bcd5'
        ]);
    }

    public function articles($articles)
    {
        ArticlesHelper::store($articles, [
            'title' => 'Tracking with deep networks',
            'type' => 'markedown',
            'paragraph' => '
                <p>Tracking is the process of locating a user selected object in different frames as it moves around the scene. It has a variety of uses such as human-computer interactions, gesture recognition, driver assistance systems, security monitoring, medical imaging and agricultural automations. There has been extensive studies for tracking during the last four decades and many different tracking algorithms have been proposed. However, all these trackers are limited to simple scenarios such as no occlusion, illumination or appearance change and no complex object motion. On the other hand we have such perfect tracker examples: humans and animals!! The human visual system object tracking performance is currently unsurpassed by engineered systems, thus our research tries to take inspiration and reverse-engineer the known principles of cortical processing during visual tracking.Inspired by recent ﬁndings on shallow feature extractors of the visual cortex, we postulate that simple tracking processes are based on a shallow neural network that can identify quickly similarities between object features repeated in time. We propose an algorithm that can track and extract motion of an object based on the similarity between local features observed in subsequent frames. The local features are initially deﬁned as a bounding box that deﬁnes the object to track.  </p>
                <hr>
                <p><strong>The Similarity Matching Ratio (SMR) Tracker</strong></p>
                <p>The SMR tracker achieved the state-of-the-art performance on the TLD [1] dataset as presented in Table 2. See the SMR Paperto learn more about it!! Download the code and try yourself! </p>
                <p>Figure 1 shows snopshots from videos and Table 1 lists the properties. Detection is considered to be correct if its overlap with ground truth bounding box is larger than 25% .  </p>
                <p><img src="https://cdn-images-1.medium.com/max/800/0*4Ke_pln7m-R_0Sho.png" alt="image"></p>
                <p><img src="https://cdn-images-1.medium.com/max/800/1*4GwIzKqD-zRYtxXAFAlACg.jpeg" alt="image"></p>
                <hr>
                <p><strong>Videos of the SMR tracker on the TLD dataset</strong><br><a href="https://www.youtube.com/watch?v=FiUbhmwtASM">David</a><br><a href="https://www.youtube.com/watch?v=zkhv6cvK-cQ">Jumping</a><br><a href="https://www.youtube.com/watch?v=Pdt7wti2wVw">Pedestrian1</a><br><a href="https://www.youtube.com/watch?v=nVhkO6ZT5sg">Pedestrian 2</a><br><a href="https://www.youtube.com/watch?time_continue=20&amp;v=gcsLCIGYvcA">Pedestrian 3</a><br><a href="https://www.youtube.com/watch?v=1eIV1r3tShg">Car</a>  </p>
                <hr>
                <p><strong>References</strong></p>
                <ol>
                <li>Z. Kalal, J. Matas, and K. Mikolajczyk. P-N Learning: Bootstrapping Binary Classiﬁers by Structural Constraints. Conference on Computer Vision and Pattern Recognition. 2010  </li>
                <li>Z. Kalal, K. Mikolajczyk. Forward-Backward Error: Automatic Detection of Tracking Failures. International Conference on Pattern Recognition. 2010.  </li>
                <li>J. Lim, D. Ross, R. Lin, and M. Yang. Incremental learning for visual tracking. NIPS, 2005.  </li>
                <li>R. Collins, Y. Liu, and M. Leordeanu. Online selection of discriminative tracking features. PAMI, 27(10):1631–1643, 2005.  </li>
                <li>S. Avidan. Ensemble tracking. PAMI, 29(2):261–271, 2007.   </li>
                <li>B. Babenko, M.-H. Yang, and S. Belongie. Visual tracking with online multiple instance learning. CVPR, 2009.  </li>
                </ol>
            ',
            'img' => 'https://firebasestorage.googleapis.com/v0/b/graduation-project-168208.appspot.com/o/development%2Fsha-elearning%2FMon%20Apr%2009%202018%2F0_4Ke_pln7m-R_0Sho.png?alt=media&token=649c6be3-7cc5-4e4d-bf60-411f4e46af68',
            'tags' => ['AI', 'CS']
        ]);
    }
}
