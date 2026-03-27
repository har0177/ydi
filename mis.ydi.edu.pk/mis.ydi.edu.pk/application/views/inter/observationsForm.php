
<div class="page-header">
    <h5 style="text-align: center; font-family: 'Baskerville Old Face'">    
        YOUTH DEVELOPMENT INSTITUTE <br>
          English Proficiency Program

    </h5>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <?php echo form_open('', ['class' => 'form-horizontal']); ?>
        <div class="table-header">
            INFORMATIONS
        </div>


        <table id="" class="table table-striped table-bordered table-hover">

            <tr><th>Name</th>
                <th><input type="text" name="name" class="form-control" placeholder="e.g Smith"></th>
                <th>Batch Name</th>
                <th><input type="text" name="batch" class="form-control" placeholder="e.g Lilly"></th>
            </tr>
            <tr>
               <th>Date:</th>
                <th><input type="text" name="date"  class="form-control datepicker" value="<?php echo date('Y-m-d'); ?>"></th>
                
            </tr>
        </table>
        <div class="table-header">
        TRAINING OBSERVATION FORM
        </div>


        <table id="" class="table table-striped table-bordered table-hover">
            <tr>
                <th>
                    Observation # 
                </th>
                <th>Level 1</th> <th>Level 2</th> <th>Level 3</th> <th>Level 4</th>
            </tr>
            <tr>
                <th colspan='5'> HOW NICELY THE TRAINERS DEALS WITH LATE COMERS?</th>
            </tr>
            <tr>
                       <th>1 </th>
                <th><input type="radio" style="height: 15px;" name="one[]" checked="" class="form-control" 
				value="25-The trainer scolds latecomers in front of the class, emphasizing the need for punctuality.">
				The trainer scolds latecomers in front of the class, emphasizing the need for punctuality.</th>
				
                <th><input type="radio" style="height: 15px;" name="one[]" class="form-control" 
				value="50-The trainer acknowledgeslatecomers but continues with the class without addressing their tardiness.">
				The trainer acknowledgeslatecomers but continues with the class without addressing their tardiness.</th>

                <th><input type="radio" style="height: 15px;" name="one[]" class="form-control" 
				value="75-The trainer politely reminds latecomers of the importance of punctuality and encourages them to arrive on time in the future.">
				The trainer politely reminds latecomers of the importance of punctuality and encourages them to arrive on time in the future.</th>
				
                <th><input type="radio" style="height: 15px;" name="one[]" class="form-control" 
				value="100-The trainer speaks with latecomers privately, discussing the importance of punctuality and consequences for repeated tardiness like fine or another polite punishment.">
		The trainer speaks with latecomers privately, discussing the importance of punctuality and consequences for repeated tardiness like fine or another polite punishment.</th>

            </tr>
             <tr>
                <th colspan='5'>  HOW THE TRAINER INTRODUCED OBJECTIVES OF THE SESSION ?</th>
            </tr>
			  <tr><th>2</th>
                <th><input type="radio" style="height: 15px;" name="two[]" checked="" class="form-control" 
				value="25-The trainer skipped the introduction of session objectives altogether, diving
straight into the lesson without setting clear expectations.
">
				The trainer skipped the introduction of session objectives altogether, diving
straight into the lesson without setting clear expectations.
</th>
				
                <th><input type="radio" style="height: 15px;" name="two[]" class="form-control" 
				value="50-The trainer briefly mentioned the session objectives but did not provide a detailed explanation, leaving
students unsure of what to expect.
">
				The trainer briefly mentioned the session objectives but did not provide a detailed explanation, leaving
students unsure of what to expect.
</th>

                <th><input type="radio" style="height: 15px;" name="two[]" class="form-control" 
				value="75-The trainer introduced the session objectives but did not explain how they would be
achieved, leaving
students unclear about the purpose of the
activities.
">
				The trainer introduced the session objectives but did not explain how they would be
achieved, leaving
students unclear about the purpose of the
activities.
</th>
				
                <th><input type="radio" style="height: 15px;" name="two[]" class="form-control" 
				value="100-The trainer provided a clear and concise explanation of the
session objectives at the beginning of the class, using whiteboard to
reinforce key points.
">
		The trainer provided a clear and concise explanation of the
session objectives at the beginning of the class, using whiteboard to
reinforce key points.
</th>

            </tr>
            
             <tr>
                <th colspan='5'> HOW HE/SHE STARTED THE SESSION (ICEBREAKER)?</th>
            </tr>
			  <tr><th>3</th>
                <th><input type="radio" style="height: 15px;" name="three[]" checked="" class="form-control" 
				value="25-The trainer started the session with a lengthy lecture or
demonstration, missing the opportunity to energize the students with an icebreaker.
">
				The trainer started the session with a lengthy lecture or
demonstration, missing the opportunity to energize the students with an icebreaker.
</th>
				
                <th><input type="radio" style="height: 15px;" name="three[]" class="form-control" 
				value="50-The trainer briefly greeted the students but did not incorporate any icebreaker activities, jumping straight into the lesson content.
">
				The trainer briefly greeted the students but did not incorporate any icebreaker activities, jumping straight into the lesson content.
</th>

                <th><input type="radio" style="height: 15px;" name="three[]" class="form-control" 
				value="75-The trainer attempted an icebreaker activity, but it was poorly
planned and did not effectively engage the students.

">
			The trainer attempted an icebreaker activity, but it was poorly
planned and did not effectively engage the students.

</th>
				
                <th><input type="radio" style="height: 15px;" name="three[]" class="form-control" 
				value="100-The trainer started the session with an engaging icebreaker activity that allowed students to interact with each other and
set a positive tone for the class.
">
		The trainer started the session with an engaging icebreaker activity that allowed students to interact with each other and
set a positive tone for the class.
</th>

            </tr>

       <tr>
                <th colspan='5'>HOW HE/SHE ENGAGED ALL STUDENTS?</th>
            </tr>
			  <tr><th>4</th>
                <th><input type="radio" style="height: 15px;" name="four[]" checked="" class="form-control" 
				value="25-Neglecting to interact directly with students.
">
			Neglecting to interact directly with students.
</th>
				
                <th><input type="radio" style="height: 15px;" name="four[]" class="form-control" 
				value="50-The trainer primarily focused on lecturing, leaving little opportunity for
student participation or engagement.

">
			The trainer primarily focused on lecturing, leaving little opportunity for
student participation or engagement.

</th>

                <th><input type="radio" style="height: 15px;" name="four[]" class="form-control" 
				value="75-The trainer attempted to engage students but consistently called on the same few
participants, leaving others feeling overlooked.


">
			The trainer attempted to engage students but consistently called on the same few
participants, leaving others feeling overlooked.


</th>
				
                <th><input type="radio" style="height: 15px;" name="four[]" class="form-control" 
				value="100-The trainer used a variety of interactive teaching methods, such as group discussions, hands-on
activities, and role-playing, to ensure all students were actively involved in the learning process.

">
	The trainer used a variety of interactive teaching methods, such as group discussions, hands-on
activities, and role-playing, to ensure all students were actively involved in the learning process.

</th>



            </tr>
            
                  <tr>
                <th colspan='5'>WHAT KIND OF AV AIDS DID HE/SHE USE FOR TEACHING?</th>
            </tr>
			  <tr><th>5</th>
                <th><input type="radio" style="height: 15px;" name="five[]" checked="" class="form-control" 
				value="25-The trainer relied solely on traditional teaching methods without utilizing any audiovisual aids.
">
The trainer relied solely on traditional teaching methods without utilizing any audiovisual aids.
</th>
				
                <th><input type="radio" style="height: 15px;" name="five[]" class="form-control" 
				value="50-The trainer used audiovisual aids sparingly and ineffectively, failing to enhance the learning experience or capture students' attention.

">The trainer used audiovisual aids sparingly and ineffectively, failing to enhance the learning experience or capture students' attention.

</th>

                <th><input type="radio" style="height: 15px;" name="five[]" class="form-control" 
				value="75-The trainer attempted to use audiovisual aids but encountered technical difficulties that disrupted the flow of the lesson.

">
		The trainer attempted to use audiovisual aids but encountered technical difficulties that disrupted the flow of the lesson.

</th>
				
                <th><input type="radio" style="height: 15px;" name="five[]" class="form-control" 
				value="100-The trainer effectively incorporated a variety of audiovisual aids such as videos, slideshows, and interactive presentations to enhance the learning experience.

">
	The trainer effectively incorporated a variety of audiovisual aids such as videos, slideshows, and interactive presentations to enhance the learning experience.

</th>



            </tr>
            
               <th colspan='5'>HOW MUCH IS THE RATIO OF STUDENT TALKING TIME AND TRAINER TALKING TIME IN
 
THE SESSION?
</th>
            </tr>
			  <tr><th>6</th>
                <th><input type="radio" style="height: 15px;" name="six[]" checked="" class="form-control" 
				value="25-The trainer
dominated the conversation,
speaking for the majority of the
session and leaving little time for student input or interaction.

">The trainer
dominated the conversation,
speaking for the majority of the
session and leaving little time for student input or interaction.


</th>
				
                <th><input type="radio" style="height: 15px;" name="six[]" class="form-control" 
				value="50-The trainer allowed students to talk freely
but did not provide adequate guidance or facilitation, resulting
in disjointed
discussions or off- topic conversations.


">The trainer allowed students to talk freely
but did not provide adequate guidance or facilitation, resulting
in disjointed
discussions or off- topic conversations.


</th>

                <th><input type="radio" style="height: 15px;" name="six[]" class="form-control" 
				value="75-The trainer encouraged students to speak but frequently interrupted or corrected them,
hindering their ability to express themselves freely.

">
The trainer encouraged students to speak but frequently interrupted or corrected them,
hindering their ability to express themselves freely.

</th>
				
                <th><input type="radio" style="height: 15px;" name="six[]" class="form-control" 
				value="100-The trainer ensured a
balanced ratio of student talking time (70%) and trainer talking time (30%), allowing ample opportunities for students to participate and engage in discussions.


">The trainer ensured a
balanced ratio of student talking time (70%) and trainer talking time (30%), allowing ample opportunities for students to participate and engage in discussions.


</th>



            </tr>
            
            </tr>
            
               <th colspan='5'>HOW HE/SHE APPRECIATED ENCOURAGED THE TRAINEES?</th>
            </tr>
			  <tr><th>7</th>
                <th><input type="radio" style="height: 15px;" name="seven[]" checked="" class="form-control" 
				value="25-The trainer criticized or belittled students instead of offering constructive feedback or encouragement.
">
The trainer criticized or belittled students instead of offering constructive feedback or encouragement.
</th>
				
                <th><input type="radio" style="height: 15px;" name="seven[]" class="form-control" 
				value="50-The trainer gave generic praise,
neglecting individual achievements.


">The trainer gave generic praise,
neglecting individual achievements.


</th>

                <th><input type="radio" style="height: 15px;" name="seven[]" class="form-control" 
				value="75-The trainer rarely offered praise or encouragement, focusing more on
pointing out mistakes or areas for improvement.

">The trainer rarely offered praise or encouragement, focusing more on
pointing out mistakes or areas for improvement.


</th>
				
                <th><input type="radio" style="height: 15px;" name="seven[]" class="form-control" 
				value="100-The trainer regularly
praised and encouraged students for their efforts, providing
specific feedback and acknowledging their contributions to the class.


">The trainer regularly
praised and encouraged students for their efforts, providing
specific feedback and acknowledging their contributions to the class.


</th>



            </tr>
            
            </tr>
            
               <th colspan='5'>WHAT KIND OF ENERGIZERS DID HE/SHE USE FOR CREATING A CONDUCIVE ENVIRONMENT?</th>
            </tr>
			  <tr><th>8</th>
                <th><input type="radio" style="height: 15px;" name="eight[]" checked="" class="form-control" 
				value="25-The trainer neglected to include any energizers, leading to periods of low energy and decreased
student engagement.

">
The trainer neglected to include any energizers, leading to periods of low energy and decreased
student engagement.

</th>
				
                <th><input type="radio" style="height: 15px;" name="eight[]" class="form-control" 
				value="50-The trainer attempted to use energizers but
did so in a way that felt forced or unnatural, failing to effectively
boost morale or enthusiasm.


">The trainer attempted to use energizers but
did so in a way that felt forced or unnatural, failing to effectively
boost morale or enthusiasm.


</th>

                <th><input type="radio" style="height: 15px;" name="eight[]" class="form-control" 
				value="75-The trainer relied
solely on lecture- based teaching
without considering the need for breaks or opportunities for movement and interaction.

">The trainer relied
solely on lecture- based teaching
without considering the need for breaks or opportunities for movement and interaction.


</th>
				
                <th><input type="radio" style="height: 15px;" name="eight[]" class="form-control" 
				value="100-The trainer incorporated energizing activities such as stretching exercises, walking, or team-building games to maintain a
positive and dynamic classroom atmosphere.


">
The trainer incorporated energizing activities such as stretching exercises, walking, or team-building games to maintain a
positive and dynamic classroom atmosphere.

</th>



            </tr>
            
            
            </tr>
            
               <th colspan='5'>HOW THE TRAINER ASSIGNED HOMEWORK?</th>
            </tr>
			  <tr><th>9</th>
                <th><input type="radio" style="height: 15px;" name="nine[]" checked="" class="form-control" 
				value="25-The trainer neglected to assign homework
altogether, missing an opportunity to
reinforce learning outside of the classroom.

">
The trainer neglected to assign homework
altogether, missing an opportunity to
reinforce learning outside of the classroom.

</th>
				
                <th><input type="radio" style="height: 15px;" name="nine[]" class="form-control" 
				value="50-The trainer assigned homework but failed to follow up on students'
progress or provide support if they encountered
difficulties.


">The trainer assigned homework but failed to follow up on students'
progress or provide support if they encountered
difficulties.


</th>

                <th><input type="radio" style="height: 15px;" name="nine[]" class="form-control" 
				value="75-The trainer hastily assigned homework without explaining its
relevance or
providing guidance on how to complete it.

">
The trainer hastily assigned homework without explaining its
relevance or
providing guidance on how to complete it.

</th>
				
                <th><input type="radio" style="height: 15px;" name="nine[]" class="form-control" 
				value="100-The trainer clearly explained the purpose of the homework assignment and provided detailed instructions for completion, ensuring
students understood what was expected of them.


">The trainer clearly explained the purpose of the homework assignment and provided detailed instructions for completion, ensuring
students understood what was expected of them.


</th>



            </tr>
            
            
            </tr>
            
               <th colspan='5'>HOW HE/SHE ENGAGED SLOW LEARNERS?</th>
            </tr>
			  <tr><th>10</th>
                <th><input type="radio" style="height: 15px;" name="ten[]" checked="" class="form-control" 
				value="25-The trainer ignored slow learners or
became frustrated with their progress, causing them to feel discouraged or left behind

">
The trainer ignored slow learners or
became frustrated with their progress, causing them to feel discouraged or left behind

</th>
				
                <th><input type="radio" style="height: 15px;" name="ten[]" class="form-control" 
				value="50-The trainer provided resources or materials for slow learners to review independently but
did not offer any additional support during class time.


">The trainer provided resources or materials for slow learners to review independently but
did not offer any additional support during class time.


</th>

                <th><input type="radio" style="height: 15px;" name="ten[]" class="form-control" 
				value="75-The trainer attempted to engage slow learners but did so in a way that singled them out or embarrassed them in front of the class.
">
The trainer attempted to engage slow learners but did so in a way that singled them out or embarrassed them in front of the class.
</th>
				
                <th><input type="radio" style="height: 15px;" name="ten[]" class="form-control" 
				value="100-The trainer provided additional support and
personalized attention to slow learners, offering extra explanations, examples, or one-on-one assistance as needed.


">
The trainer provided additional support and
personalized attention to slow learners, offering extra explanations, examples, or one-on-one assistance as needed.

</th>



            </tr>
            
            
            </tr>
            
               <th colspan='5'>DID HE PREPARE LESSON PLAN AND HOW DID HE EXECUTE IT?</th>
            </tr>
			  <tr><th>11</th>
                <th><input type="radio" style="height: 15px;" name="eleven[]" checked="" class="form-control" 
				value="25-Trainer did not seem to have a lesson plan or any structured
approach to the session.

">
Trainer did not seem to have a lesson plan or any structured
approach to the session.

</th>
				
                <th><input type="radio" style="height: 15px;" name="eleven[]" class="form-control" 
				value="50-Trainer appeared to have a basic outline for the session but did not
follow a structured lesson plan.


">Trainer appeared to have a basic outline for the session but did not
follow a structured lesson plan.


</th>

                <th><input type="radio" style="height: 15px;" name="eleven[]" class="form-control" 
				value="75-Trainer mentioned having a plan but the session lacked structure and coherence, with
activities seeming improvised.

">Trainer mentioned having a plan but the session lacked structure and coherence, with
activities seeming improvised.


</th>
				
                <th><input type="radio" style="height: 15px;" name="eleven[]" class="form-control" 
				value="100-The trainer prepared detailed lesson plan, executed it effectively and students were engaged effectively.

">
The trainer prepared detailed lesson plan, executed it effectively and students were engaged effectively.
</th>



            </tr>
            
            
            </tr>
            
               <th colspan='5'>HOW DID HE EMPLOYED STRATEGIES TO ACHIEVE THE SESSION OBJECTIVES?</th>
            </tr>
			  <tr><th>12</th>
                <th><input type="radio" style="height: 15px;" name="twelve[]" checked="" class="form-control" 
				value="25-There were NO
discernible strategies employed, objectives not met effectively.

">
There were NO
discernible strategies employed, objectives not met effectively.

</th>
				
                <th><input type="radio" style="height: 15px;" name="twelve[]" class="form-control" 
				value="50-The trainer used limited range of
strategies to achieve the session objectives.
However, these
strategies were not implemented effectively.


">The trainer used limited range of
strategies to achieve the session objectives.
However, these
strategies were not implemented effectively.


</th>

                <th><input type="radio" style="height: 15px;" name="twelve[]" class="form-control" 
				value="75-Trainer attempted to use strategies to
achieve the session objectives but lacked clarity and coherence.

">Trainer attempted to use strategies to
achieve the session objectives but lacked clarity and coherence.


</th>
				
                <th><input type="radio" style="height: 15px;" name="twelve[]" class="form-control" 
				value="100-The trainer employed a diverse range of teaching
methods which were executed effectively, ensuring active engagement and comprehension among students.


">
The trainer employed a diverse range of teaching
methods which were executed effectively, ensuring active engagement and comprehension among students.

</th>



            </tr>
            
            
                </tr>
            
               <th colspan='5'>HOW  PROFICIENT  IS  THE  TRAINER  IN  TERMS  OF  FLUENCY, PRONUNCIATION, SENTENCE STRUCTURE AND UNDERSTANDING OF THE TOPIC?</th>
            </tr>
			  <tr><th>13</th>
                <th><input type="radio" style="height: 15px;" name="thirteen[]" checked="" class="form-control" 
				value="25-The trainer faces challenges in all four areas and requires
significant development and practice to become proficient and effective


">
The trainer faces challenges in all four areas and requires
significant development and practice to become proficient and effective


</th>
				
                <th><input type="radio" style="height: 15px;" name="thirteen[]" class="form-control" 
				value="50-The trainer demonstrates
satisfactory skills in two areas but require some development to reach a good standard.



">The trainer demonstrates
satisfactory skills in two areas but require some development to reach a good standard.



</th>

                <th><input type="radio" style="height: 15px;" name="thirteen[]" class="form-control" 
				value="75-The trainer shows strength in three
areas but may need some improvement in the remaining
area to achieve excellence.


">The trainer shows strength in three
areas but may need some improvement in the remaining
area to achieve excellence.



</th>
				
                <th><input type="radio" style="height: 15px;" name="thirteen[]" class="form-control" 
				value="100-The trainer demonstrates
exceptional fluency,
pronunciation, sentence structure, and
understanding of the topic

">
The trainer demonstrates
exceptional fluency,
pronunciation, sentence structure, and
understanding of the topic

</th>



            </tr>
            
            
            
            
            
        </table>

        <div class="form-group">
            <div class="col-xs-12 col-sm-4 pull-right">
                <label>
                    <input type="submit" name="submit" value="Submit Details" class="btn btn-lg btn-success">
                </label>
            </div>
        </div>
        </form>
    </div>
</div>
