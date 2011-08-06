<?php print '<?xml version="1.0" encoding="UTF-8" ?>'; ?>

<!--
 Licensed to the Apache Software Foundation (ASF) under one or more
 contributor license agreements.  See the NOTICE file distributed with
 this work for additional information regarding copyright ownership.
 The ASF licenses this file to You under the Apache License, Version 2.0
 (the "License"); you may not use this file except in compliance with
 the License.  You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
-->

<!--
 This is a stripped down config file used for a simple example...  
 It is *not* a good example to work from. 
-->
<config>
  <updateHandler class="solr.DirectUpdateHandler2" />

  <requestDispatcher handleSelect="true" >
    <requestParsers enableRemoteStreaming="false" multipartUploadLimitInKB="2048" />
  </requestDispatcher>

   <!-- The spell check component can return a list of alternative spelling
  suggestions.  -->
  <searchComponent name="spellcheck" class="solr.SpellCheckComponent">

    <str name="queryAnalyzerFieldType">textSpell</str>

    <lst name="spellchecker">
      <str name="name">default</str>
      <str name="field">spell</str>
      <str name="spellcheckIndexDir">./spellchecker1</str>
      <str name="buildOnOptimize">true</str>
    </lst>
    <lst name="spellchecker">
      <str name="name">jarowinkler</str>
      <str name="field">spell</str>
      <!-- Use a different Distance Measure -->
      <str name="distanceMeasure">org.apache.lucene.search.spell.JaroWinklerDistance</str>
      <str name="spellcheckIndexDir">./spellchecker2</str>
      <str name="buildOnOptimize">true</str>
    </lst>

  </searchComponent>
  
  <queryConverter name="queryConverter" class="solr.SpellingQueryConverter"/>

  <requestHandler name="standard" class="solr.StandardRequestHandler" default="true">
    <lst name="defaults">
      <str name="spellcheck"><?php print $settings['spell_suggest'] ? "true" : "false"; ?></str>
    <!-- Defaults for the spell checker when used -->
      <str name="spellcheck.onlyMorePopular">true</str>
      <str name="spellcheck.extendedResults">false</str>
      <!--  The number of suggestions to return -->
      <str name="spellcheck.count">1</str>
    </lst>
    <arr name="last-components">
      <str>spellcheck</str>
    </arr>
   </requestHandler>
  <requestHandler name="/update" class="solr.XmlUpdateRequestHandler" />
  <requestHandler name="/admin/" class="org.apache.solr.handler.admin.AdminHandlers" />
      
  <!-- config for the admin interface --> 
  <admin>
    <defaultQuery>solr</defaultQuery>
  </admin>

</config>

