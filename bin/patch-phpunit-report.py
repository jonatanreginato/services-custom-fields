#!/usr/bin/env python
# coding: utf-8

import sys
import xml.etree.ElementTree as ET


report_file_path = 'target/unit/report.xml'

if (len(sys.argv) > 1):
    report_file_path = sys.argv[1]

et = ET.parse(report_file_path)
root = et.getroot()

parent_map = dict((c, p) for p in root.getiterator() for c in p)

# Step 1: find dataProvider tests
data_provider_suites = []
for item in root.iter("testcase"):
    if "with data set " in item.attrib['name']:
        suite = parent_map[item]
        if suite not in data_provider_suites:
            data_provider_suites.append(suite)

# Step 2: move testcases up by 1 node level
for suite in data_provider_suites:
    parent_suite = parent_map[suite]
    for testcase in suite:
        parent_suite.append(testcase)

    suite_id = id(suite)
    for s in parent_suite:
        if (id(s) == suite_id):
            parent_suite.remove(s)

et.write(report_file_path)
print('Patched PHPUnit report for Sonarqube:' + report_file_path)
