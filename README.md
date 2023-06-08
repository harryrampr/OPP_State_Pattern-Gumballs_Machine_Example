### State Pattern (OOP) - Gumballs Machine Example

We are sharing some simple PHP code, showing the use of
the [State Pattern](https://en.wikipedia.org/wiki/State_pattern). You will see how modern versions
of PHP, supporting Classes and Interfaces, make it easy to implement the State Pattern using this language.

You can find the PHP 8.1 code
at [/app/src](https://github.com/harryrampr/OPP_State_Pattern-Gumballs_Machine_Example/tree/master/app/src), there is
testing at [/tests](https://github.com/harryrampr/OPP_State_Pattern-Gumballs_Machine_Example/tree/master/app/tests)
directory. HTML output with Tailwind CSS can be found
at [/app/public](https://github.com/harryrampr/OPP_State_Pattern-Gumballs_Machine_Example/tree/master/app/public)
directory.

### About the Pattern

The State pattern is a behavioral design pattern
in [object-oriented programming](https://en.wikipedia.org/wiki/Object-oriented_programming) that allows an object to
alter its behavior when its internal state changes. It encapsulates states as distinct classes and delegates the
behavior associated with each state to these classes. The object's behavior varies dynamically based on its internal
state, without the need for conditional statements.

### History

The concept of representing the behavior of an object based on its internal state has been present in programming since
the early days of structured programming. However, the formalization of the State pattern as a design pattern can be
attributed to the
book ["Design Patterns: Elements of Reusable Object-Oriented Software"](https://en.wikipedia.org/wiki/Design_Patterns)
by Erich Gamma, Richard Helm, Ralph Johnson, and John Vlissides, commonly known as the Gang of Four (GoF). Published in
1994, the book introduced the State pattern as one of the 23 foundational design patterns.

The State pattern itself was influenced by related concepts such
as [finite state machines](https://en.wikipedia.org/wiki/Finite-state_machine) (FSMs) and [state transition
diagrams](https://en.wikipedia.org/wiki/State_diagram). Finite state machines have been widely used in fields like
electrical engineering, control systems, and formal language theory. The State pattern abstracts and encapsulates the
behavior associated with different states in a more flexible and object-oriented manner.

### Intent

The State pattern aims to provide a clean and extensible way to manage object behavior that varies based on its internal
state. It promotes encapsulation by representing each state as a separate class and allows objects to transition between
states while maintaining their interface.

### Structure

- **Context:** Represents the object whose behavior is influenced by its internal state. It maintains a reference to the
  current state object and delegates the behavior to the state object.
- **State:** Defines an interface or abstract class for encapsulating the behavior associated with a particular state of
  the Context.
- **ConcreteState:** Implements the behavior associated with a specific state of the Context.

### How it Works

1. The Context object maintains a reference to the current State object, initially set to a default state.
2. Clients interact with the Context object, invoking methods on it.
3. The Context delegates the behavior to the current State object.
4. When the internal state of the Context changes, it updates the current State object to the appropriate ConcreteState
   object.
5. The Context continues to delegate behavior to the new State object, and clients perceive the changed behavior
   accordingly.

### Benefits

- Promotes clean separation and encapsulation of behavior associated with different states.
- Simplifies code by removing complex conditional statements based on the object's state.
- Allows new states to be added easily without modifying existing code.
- Supports the "Open-Closed Principle" by allowing behavior modification without changing the Context class.
- Facilitates the sharing of state-related code and prevents duplication.

### Applications

- **State Machines:** State machines or workflows often employ the State pattern to model the different states and
  transitions between them. Examples include order processing systems, ticketing systems, or game engines where entities
  have different behaviors based on their current state.

- **User Interface (UI) Development:** Graphical user interfaces often use the State pattern to manage different UI
  states and their corresponding behavior. This allows for dynamic updating of the UI based on user interactions or
  system events. Examples include form validation, wizard-like interfaces, or multi-step processes.

- **Network Protocols:** Network protocols that involve complex state transitions, such as TCP/IP, can benefit from the
  State pattern. Each state of the protocol is represented by a separate state class, making it easier to manage
  protocol-specific behavior and transitions.

- **Document Processing:** Applications that involve document processing, such as text editors or compilers, can use the
  State pattern to handle different states of the document. For example, a text editor may have states
  like "read-only," "editing," or "preview," with each state having its own behavior and restrictions.

- **Game Development:** Game development often utilizes the State pattern to manage the behavior of game entities or
  characters based on their current state. This allows for dynamic and context-sensitive behavior, such as different
  movements, interactions, or AI strategies based on the game state.

- **Traffic Light Systems:** Traffic light systems can employ the State pattern to represent the different states of a
  traffic light (e.g., green, yellow, red) and the corresponding behavior and transitions between states.

- **Concurrent Programming:** The State pattern can be used in concurrent programming scenarios where the behavior of an
  object needs to adapt based on synchronization or locking states. It can help manage the synchronization and
  coordination between different threads or processes.

- **Workflow Management:** Workflow management systems or business process automation can utilize the State pattern to
  model and control the different states and actions within a workflow. This allows for flexible and extensible workflow
  behavior.

- **Financial Applications:** Financial applications, such as banking systems or investment platforms, often have
  complex state-dependent behavior. The State pattern can be used to represent different financial states (e.g., active,
  closed, pending) and handle behavior specific to each state.

- **Embedded Systems:** The State pattern is applicable to embedded systems where devices may have different operational
  states. Examples include power management systems, sensor-based systems, or control systems for industrial automation.

### Other Examples

Consider a document editing application used in a real-life scenario. When you start creating a new document, it begins
in a "Draft" state, allowing you to make changes and updates. Once you're satisfied with the document, you can submit it
for review, transitioning it to the "Review" state. During the review process, others can provide feedback and
suggestions, while you are restricted from making direct edits. After the document receives approval, it enters
the "Published" state, becoming view-only and ready to be shared with others. The State pattern enables the application
to seamlessly manage the document's different states, ensuring a smooth workflow and appropriate access restrictions at
each stage.