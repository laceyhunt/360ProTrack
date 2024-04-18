import csv
from collections import defaultdict
import networkx as nx
import matplotlib.pyplot as plt
# import pygraphviz as pgv


def find_paths(graph, node, slackTimes, paths):
    if not graph[node]:
        paths[-1].append(node)
        paths.append([])
        #print(node)
        return
    elif slackTimes[node] == 0:
        paths[-1].append(node)
        #print('{} -> '.format(node), end = '')
        for nxt in graph[node]:
            find_paths(graph, nxt, slackTimes, paths)

def print_graph_info(graph):
    print("Number of nodes:", graph.number_of_nodes())
    print("Number of edges:", graph.number_of_edges())


def make_pert_chart(graph, startTimes, completionTimes, slackTimes, criticalPaths):
    node_size = 1000  # Adjust the node size as needed
    # Convert graph dictionary to a NetworkX graph
    g = nx.DiGraph()
    for parent, children in graph.items():
        for child in children:
            g.add_edge(parent, child)

    criticalEdges = defaultdict(list)

    for path in criticalPaths:
        for i in range(len(path) - 1):
            criticalEdges[path[i] + path[i+1]] = True

    labelsDict = {}
    for parent in graph:
        for child in graph[parent]:
            parentStr = '{} {} {}'.format(startTimes[parent], completionTimes[parent], slackTimes[parent])
            childStr = '{} {} {}'.format(startTimes[child], completionTimes[child], slackTimes[child])
            labelsDict[parent] = parentStr
            labelsDict[child] = childStr
            g.add_edge(parent, child, color='black')

    # Sort nodes by start time
    sorted_nodes = sorted(startTimes.keys(), key=lambda x: startTimes[x])

    # Calculate horizontal position based on start time
    pos = {}
    for i, node in enumerate(sorted_nodes):
        pos[node] = (startTimes[node], -i)

    # Adjust vertical position to prevent overlap
    # for node in sorted_nodes:
    #     x, y = pos[node]
    #     neighbors = list(g.neighbors(node))
    #     if neighbors:
    #         avg_y = sum(pos[neighbor][1] for neighbor in neighbors) / len(neighbors)
    #         pos[node] = (x, avg_y)
    # Adjust vertical position to prevent overlap
    for node_index, node in enumerate(sorted_nodes):
        x, y = pos[node]
        # Check for existing nodes in the same vertical position
        existing_nodes = [n for n, (nx, ny) in pos.items() if ny == y]
        if existing_nodes:
            # If there are existing nodes at the same vertical position, move the new node down
            y_offset = (len(existing_nodes)+4) * 0.5 # Adjust this value as needed
            # y_offset=1
            pos[node] = (x, y - y_offset)
        else:
            pos[node] = (x, y+1)        

    # Maintain a dictionary to track the maximum y-coordinate of each horizontal position
    max_y_for_x = defaultdict(float)

    for task in sorted_nodes:
        x, y = pos[task]
        plt.text(x, y + 0.35, s=labelsDict[task], bbox=dict(facecolor='lightgrey', alpha=1,pad=0.2), horizontalalignment='center')

        # Update max_y_for_x for the current horizontal position
        max_y_for_x[x] = max(max_y_for_x[x], y + 0.3)

    # Draw nodes as rectangles
    node_shapes = {node: 's' for node in sorted_nodes}

    print_graph_info(g)

    edges = list(g.edges())
    colors = [g[u][v]['color'] for u, v in edges]

    nx.draw(g, pos, with_labels=True, edge_color=colors, node_shape='s', node_size=1000, node_color='darkseagreen')
    plt.savefig('pert.png', bbox_inches='tight')
    # plt.show()



def make_gantt_chart(graph, startTimes, completionTimes, durations, slackTimes):
    
    fig, ax = plt.subplots()
    y_values = sorted(startTimes.keys(), key = lambda x: startTimes[x])
    y_start = 40
    # y_start = 0
    y_height = 5
    for value in y_values:
        ax.broken_barh([(startTimes[value], durations[value])], (y_start, y_height), facecolors = 'darkseagreen')
        ax.broken_barh([(completionTimes[value], slackTimes[value])], (y_start, y_height), facecolors = 'lightgrey')
        ax.text(completionTimes[value] + slackTimes[value] + 0.5,y_start + y_height/2, value)
        y_start += 10
    ax.set_xlim(0, max(completionTimes.values()) + 5)
    ax.set_ylim(len(durations)*20)
    ax.set_xlabel('Time')
    ax.set_ylabel('Tasks')
    i = 5
    y_ticks = []
    y_ticklabels = []
    while i < len(durations)*20:    
        y_ticks.append(i)
        i += 10
    ax.set_yticks(y_ticks)
    plt.tick_params(
    axis='y',          # changes apply to the x-axis
    which='both',      # both major and minor ticks are affected
    left='off',         # ticks along the top edge are off
    labelleft='off') # labels along the bottom edge are off
    plt.savefig('gantt.png', bbox_inches = 'tight')
    # plt.show()


def main(filename):

    graph = defaultdict(list)
    duration = {}
    
    try:
        with open(filename, newline = '') as csvfile:
            reader = csv.reader(csvfile)
            next(reader)
            for row in reader:
                nodes = row[2].split(' ')
                for node in nodes:
                    graph[node].append(row[0])
                duration[row[0]] = int(row[1])
    except:
        return -1
    
    tasks = duration.keys()
    
    #initialize start times
    startTimes = {}
    for task in graph['NONE']:
        startTimes[task] = 0
    graph.pop('NONE', None)
    
    # calculate start times
    while len(startTimes) < len(tasks): # while any node doesn't have a start time
        for task in tasks: # loop through all tasks
            if task not in startTimes: # if the task doesn't have a start time yet
                startTime = 0 # initialize start time to be some minimum value
                flag = True
                for parent in graph: # look for all tasks it depends on i.e. all nodes pointing to it
                    if task in graph[parent]: # we found a parent
                        if parent in startTimes: # if the parent has a start time, compare it to current max
                            startTime = max(startTime, startTimes[parent] + duration[parent])
                        else: # else, one of the parents doesn't have a start time, so we can't calculate start time of current task yet
                            flag = False
                if flag:
                    startTimes[task] = startTime
    
    # calculate completion times
    completionTimes = {}
    for task in tasks:
        completionTimes[task] = startTimes[task] + duration[task]
    
    # calculate slack times
    slackTimes = {}
    for task in tasks:
        slackTime = 9999999999999999999#;
        for node in graph[task]:
            slackTime = min(slackTime, startTimes[node] - completionTimes[task])
        if not graph[task]:
            slackTimes[task] = 0
        else:
            slackTimes[task] = slackTime
    
    print('start times: {}'.format(startTimes))
    print('completion times: {}'.format(completionTimes))
    print('slack times: {}'.format(slackTimes))
    
    # find critical paths
    criticalPaths = [[]]
    for node in graph:
        if startTimes[node] == 0:
            find_paths(graph, node, slackTimes, criticalPaths)
    criticalPaths.pop()
    print(criticalPaths)
    
    make_pert_chart(graph, startTimes, completionTimes, slackTimes, criticalPaths)
    make_gantt_chart(graph, startTimes, completionTimes, duration, slackTimes)
    
if __name__ == '__main__':
    print("hey its me!!!")
    main('temp_csv/tasks.csv')