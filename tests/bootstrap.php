<?php
/**
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * File containing the test bootstrap script.
 */
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
$loader->addPsr4('Svea\\Checkout\\Tests\\', __DIR__.'/');
date_default_timezone_set('UTC');